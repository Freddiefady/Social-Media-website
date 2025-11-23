<script setup>
import { computed, ref } from 'vue'
import { BookmarkIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import { useForm, usePage } from "@inertiajs/vue3";
import IndigoButton from "@/Components/app/IndigoButton.vue";
import TextInput from "@/Components/TextInput.vue";
import BaseModal from "@/Components/app/BaseModal.vue";

const formErrors = ref({})

const props = defineProps({
    modelValue: Boolean
})

const form = useForm({
    email: '',
})

const emit = defineEmits(['update:modelValue', 'hide', 'create'])

const page = usePage()

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
    form.post(route('group.invite', page.props.group.slug), {
        onSuccess(res) {
            closeModal()
            console.log(res)
        },
        onError(res) {
            console.log(res)
        }
    })
}
</script>

<template>
    <BaseModal title="Invite User" v-model="show" @hide="closeModal">
        <div class="p-4 dark:text-gray-100">
            <div class="mt-3">
                <label>Email or Username</label>
                <TextInput
                    type="text"
                    class="mt-1 block w-full"
                    :class="page.props.errors.email ? 'text-red-500 focus:ring-red-500 focus:border-red-500' : ''"
                    v-model="form.email"
                    required
                    autofocus
                />
            </div>
            <div class="text-red-500">{{ page.props.errors.email }}</div>
        </div>

        <div class="flex justify-end gap-2 py-3 px-4">
            <button @click="closeModal"
                    class="text-gray-800 flex gap-1 items-center justify-center bg-gray-100 rounded-md hover:bg-gray-200 py-2 px-4">
                <XMarkIcon class="h-5 w-5"/>
                Cancel
            </button>
            <IndigoButton type="submit" @click="submit">
                <BookmarkIcon class="w-4 h-4 mr-2"/>
                Submit
            </IndigoButton>
        </div>
    </BaseModal>
</template>
