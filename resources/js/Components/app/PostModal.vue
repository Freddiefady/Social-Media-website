<script setup>
import { computed, ref, watch } from 'vue'
import { XMarkIcon, PaperClipIcon, BookmarkIcon, ArrowUturnLeftIcon, SparklesIcon } from '@heroicons/vue/24/outline'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'
import InputTextArea from "@/Components/InputTextArea.vue";
import PostUserHeader from "@/Components/app/PostUserHeader.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { isImage } from "@/helpers.js";
import IndigoButton from "@/Components/app/IndigoButton.vue";
import axiosClient from "@/axiosClient.js";

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
    group: {
        type: Object,
        default: null,
    },
    modelValue: Boolean
})

const attachmentExtensions = usePage().props.attachmentExtensions;

/**
 * {
 *     file: File,
 *     url: '',
 * }
 * @type {Ref<UnwrapRef<*[]>, UnwrapRef<*[]> | *[]>}
 */
const attachmentFiles = ref([])
const attachmentErrors = ref([])
const aiButtonLoading = ref(false);
const formErrors = ref({})

const form = useForm({
    body: '',
    group_id: null,
    attachments: [],
    deleted_file_ids: [],
    _method: 'POST'
})

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})

const computedAttachments = computed(() => {
    if (props.post) {
        return [...attachmentFiles.value, ...(props.post.attachments || [])]
    }
    return attachmentFiles.value
})

const showExtensionsText = computed(() => {
    for (let myFile of attachmentFiles.value) {
        const file = myFile.file
        let parts = file.name.split('.')
        let ext = parts.pop().toLowerCase()
        if (! attachmentExtensions.includes(ext)) {
            return true
        }
    }
    return false
})

const emit = defineEmits(['update:modelValue', 'hide'])

watch(() => props.post, () => {
    form.body = props.post.body || ''
})

function closeModal() {
    show.value = false
    emit('hide')
    resetModal();
}

function resetModal() {
    form.reset()
    formErrors.value = {}
    attachmentFiles.value = []
    attachmentErrors.value = false
    if (props.post.attachments) {
        props.post.attachments.forEach(file => file.deleted = false)
    }
}

function submit() {
    if (props.group) {
        form.group_id = props.group.id
    }
    form.attachments = attachmentFiles.value.map(myFile => myFile.file)
    if (props.post.id) {
        form._method = "PUT"
        form.post(route('post.update', props.post.id), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal()
            },
            onError: (errors) => {
                processErrors(errors)
            }
        })
    } else {
        form.post(route('post.store'), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal()
            },
            onError: (errors) => {
                processErrors(errors)
            }
        })
    }
}

function processErrors(errors) {
    formErrors.value = errors
    for (const key in errors) {
        if (key.includes('.')) {
            const [ ,index] = key.split('.')
            attachmentErrors.value[index] = errors[key]
        }
    }
}

async function onAttachmentChoose($event) {
    for (const file of $event.target.files) {
        const myFile = {
            file,
            url: await readFile(file)
        }
        attachmentFiles.value.push(myFile)
    }
    $event.target.files = null
}

async function readFile(file) {
    return new Promise((res, rej) => {
        if (isImage(file)) {
            const reader = new FileReader()
            reader.onloadend = () => {
                res(reader.result)
            }
            reader.onerror = rej
            reader.readAsDataURL(file)
        } else {
            res(null)
        }
    })
}

function removeFile(myFile) {
    if (myFile.file) {
        attachmentFiles.value = attachmentFiles.value.filter(f => f !== myFile)
    } else {
        form.deleted_file_ids.push(myFile.id)
        myFile.deleted = true
    }
}

function undoDelete(myFile) {
    myFile.deleted = false
    form.deleted_file_ids = form.deleted_file_ids.filter(id => id !== myFile.id)
}

function GenerateAIContent() {
    if (!form.body) return;
    aiButtonLoading.value = true;
    axiosClient.post(route('post.generate.ai'), {
        prompt: form.body
    })
    .then(({ data }) => {
        form.body = data.content;
        aiButtonLoading.value = false;
    })
    .catch(error => {
        console.error('Error generating content:', error);
        aiButtonLoading.value = false;
    });
}
</script>

<template>
    <teleport to="body">
        <TransitionRoot appear :show="show" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-50">
                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div class="fixed inset-0 bg-black/25"/>
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div
                        class="flex min-h-full items-center justify-center p-4 text-center"
                    >
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <DialogPanel
                                class="w-full max-w-md transform overflow-hidden rounded bg-white text-left align-middle shadow-xl transition-all"
                            >
                                <DialogTitle
                                    as="h3"
                                    class="flex items-center justify-between py-3 px-4 font-medium bg-gray-100 text-gray-900"
                                >
                                    {{ post.id ? 'Update Post' : 'Create New Post' }}
                                    <button
                                        @click="closeModal"
                                        class="w-8 h-8 rounded-full hover:bg-black/5 transition flex items-center justify-center">
                                        <XMarkIcon class="h-4 w-4"/>
                                    </button>
                                </DialogTitle>
                                <div class="p-4">
                                    <PostUserHeader :post="post" :showTime="false" class="mb-4"/>

                                    <div v-if="formErrors.group_id" class="bg-red-400 text-white py-2 px-3 rounded mb-3">
                                        {{ formErrors.group_id }}
                                    </div>

                                    <div class="relative group">
                                        <InputTextArea v-model="form.body" class="mb-3 w-full"/>

                                        <button class="absolute h-8 w-8 right-1 top-5 p-1 rounded bg-indigo-500 hover:bg-indigo-600 text-white flex justify-center items-center opacity-0 group-hover:opacity-100 transition disabled:cursor-not-allowed disabled:bg-indigo-400 disabled:hover:bg-indigo-400"
                                        :disabled="aiButtonLoading"
                                        @click="GenerateAIContent">
                                            <svg v-if="aiButtonLoading" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                            <SparklesIcon v-else class="h-5 w-5"/>
                                        </button>
                                    </div>

                                    <div v-if="showExtensionsText" class="border-l-4 border-amber-500 px-3 py-2 mt-3 text-gray-800 bg-amber-100">
                                        Files must be one of the following extensions <br>
                                        <small>{{attachmentExtensions.join(', ')}}</small>
                                    </div>

                                    <div v-if="formErrors.attachments" class="border-l-4 border-red-500 px-3 py-2 mt-3 text-gray-800 bg-red-100">
                                        {{formErrors.attachments}}
                                    </div>

                                    <div class="grid gap-3 my-3" :class="[
                                        computedAttachments.length === 1 ? 'grid-cols-1' : 'grid-cols-2'
                                    ]">
                                        <template v-for="(myFile, ind) of computedAttachments">
                                            <div
                                                class="group bg-blue-100 aspect-square flex flex-col items-center justify-center text-gray-500 relative border-2" :class="attachmentErrors[ind] ? 'border-red-500' : ''">

                                                <div v-if="myFile.deleted"
                                                     class="absolute left-0 bottom-0 right-0 py-2 px-3 bg-black text-white text-sm flex justify-between items-center">
                                                    To be Deleted
                                                    <ArrowUturnLeftIcon @click="undoDelete(myFile)"
                                                                        class="w-4 h-4 cursor-pointer"/>
                                                </div>

                                                <button
                                                    @click="removeFile(myFile)"
                                                    class="absolute z-20 right-3 top-3 w-7 h-7 bg-black/30 hover:bg-black/40 text-white rounded-full flex items-center justify-center">
                                                    <XMarkIcon class="w-5 h-5"/>
                                                </button>

                                                <img v-if="isImage(myFile.file || myFile)" :src="myFile.url"
                                                     class="object-contain"
                                                     :class="myFile.deleted ? 'opacity-50' : ''"/>

                                                <div v-else class="flex flex-col items-center justify-center px-3"
                                                     :class="myFile.deleted ? 'opacity-50' : ''">
                                                    <PaperClipIcon class="w-10 h-10 mb-3"/>
                                                    <small class="text-center">
                                                        {{ (myFile.file || myFile).name }}
                                                    </small>
                                                </div>
                                            </div>
                                            <small class="text-red-500">{{attachmentErrors[ind]}}</small>
                                        </template>
                                    </div>
                                </div>

                                <div class="flex gap-2 py-3 px-4">
                                    <IndigoButton class="relative">
                                        <PaperClipIcon class="w-4 h-4 mr-2"/>
                                        Attach Files
                                        <input @click.stop @change="onAttachmentChoose" multiple type="file"
                                               class="absolute top-0 right-0 bottom-0 left-0 opacity-0">
                                    </IndigoButton>
                                    <IndigoButton type="submit" @click="submit">
                                        <BookmarkIcon class="w-4 h-4 mr-2"/>
                                        Submit
                                    </IndigoButton>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </teleport>
</template>
