<script setup>
import { computed, ref } from 'vue'
import { BookmarkIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot, } from '@headlessui/vue'
import { useForm } from "@inertiajs/vue3";
import IndigoButton from "@/Components/app/IndigoButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import axiosClient from "@/axiosClient.js";

const props = defineProps({
    modelValue: Boolean
})

const formErrors = ref({})

const form = useForm({
    name: '',
    about: '',
    auto_approval: true,
})

const emit = defineEmits(['update:modelValue', 'hide', 'create'])

function resetModal() {
    form.reset()
    formErrors.value = {}
}

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
})

function closeModal() {
    show.value = false
    emit('hide')
    resetModal();
}


function submit() {
    axiosClient.post(route('group.store'), form)
        .then(({ data }) => {
            resetModal()
            emit('create', data);
        })
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
                    <div class="flex min-h-full items-center justify-center p-4 text-center">
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <DialogPanel class="w-full max-w-md transform overflow-hidden rounded bg-white text-left align-middle shadow-xl transition-all">
                                <DialogTitle as="h3" class="flex items-center justify-between py-3 px-4 font-medium bg-gray-100 text-gray-900">
                                    Create New Group
                                    <button
                                        @click="closeModal"
                                        class="w-8 h-8 rounded-full hover:bg-black/5 transition flex items-center justify-center">
                                        <XMarkIcon class="h-4 w-4"/>
                                    </button>
                                </DialogTitle>
                                <div class="p-4">
                                    <div class="mt-3">
                                        <label>Group Name</label>
                                        <TextInput
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.name"
                                            required
                                            autofocus
                                        />
                                    </div>

                                    <div class="mt-3">
                                        <Checkbox name="remember" v-model:checked="form.auto_approval"/>
                                        Enable Auto Approval
                                    </div>

                                    <div class="mt-3">
                                        <label>About Group</label>
                                        <textarea v-model="form.about" class="w-full"></textarea>
                                    </div>
                                </div>

                                <div class="flex justify-end gap-2 py-3 px-4">
                                    <button @click="closeModal" class="text-gray-800 flex gap-1 items-center justify-center bg-gray-100 rounded-md hover:bg-gray-200 py-2 px-4">
                                        <XMarkIcon class="h-5 w-5"/>
                                        Cancel
                                    </button>
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
