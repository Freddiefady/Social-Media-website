<script setup>
import {computed, ref, watch} from 'vue'
import {XMarkIcon, PaperClipIcon, BookmarkIcon, ArrowUturnLeftIcon} from '@heroicons/vue/24/outline'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'
import InputTextArea from "@/Components/InputTextArea.vue";
import PostUserHeader from "@/Components/app/PostUserHeader.vue";
import {useForm} from "@inertiajs/vue3";
import {isImage} from "@/helpers.js";

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
    modelValue: Boolean
})

/**
 * {
 *     file: File,
 *     url: '',
 * }
 * @type {Ref<UnwrapRef<*[]>, UnwrapRef<*[]> | *[]>}
 */
const attachmentFiles = ref([])

const form = useForm({
    body: '',
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
    attachmentFiles.value = []
    props.post.attachments.forEach(file => file.deleted = false)
}

function submit() {
    form.attachments = attachmentFiles.value.map(myFile => myFile.file)
    if (props.post.id) {
        form._method = "PUT"
        form.post(route('post.update', props.post.id), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal()
            }
        })
    } else {
        form.post(route('post.store'), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal()
            }
        })
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
                                    <InputTextArea v-model="form.body" class="mb-3 w-full"/>

                                    <div class="grid gap-3 my-3" :class="[
                                        computedAttachments.length === 1 ? 'grid-cols-1' : 'grid-cols-2'
                                    ]">
                                        <template v-for="(myFile, ind) of computedAttachments">
                                            <div
                                                class="group bg-blue-100 aspect-square flex flex-col items-center justify-center text-gray-500 relative">

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

                                                <div v-else class="flex flex-col items-center justify-center"
                                                     :class="myFile.deleted ? 'opacity-50' : ''">
                                                    <PaperClipIcon class="w-10 h-10 mb-3"/>
                                                    <small class="text-center">
                                                        {{ (myFile.file || myFile).name }}
                                                    </small>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <div class="flex gap-2 py-3 px-4">
                                    <button
                                        type="button"
                                        class="flex items-center justify-center w-full rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 relative"
                                    >
                                        <PaperClipIcon class="w-4 h-4 mr-2"/>
                                        Attach Files
                                        <input @click.stop @change="onAttachmentChoose" multiple type="file"
                                               class="absolute top-0 right-0 bottom-0 left-0 opacity-0">
                                    </button>
                                    <button
                                        type="submit"
                                        class="flex items-center justify-center w-full rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                        @click="submit"
                                    >
                                        <BookmarkIcon class="w-4 h-4 mr-2"/>
                                        Submit
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </teleport>
</template>
