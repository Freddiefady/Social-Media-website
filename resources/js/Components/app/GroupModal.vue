<script setup>
import { computed, ref } from 'vue'
import { BookmarkIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import { useForm } from "@inertiajs/vue3";
import IndigoButton from "@/Components/app/IndigoButton.vue";
import axiosClient from "@/axiosClient.js";
import GroupForm from "@/Components/app/GroupForm.vue";
import BaseModal from "@/Components/app/BaseModal.vue";

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
            closeModal()
            emit('create', data);
        })
}

</script>

<template>
    <BaseModal title="Create new group" v-model="show" @hide="closeModal">
        <div class="p-4 dark:bg-gray-900 dark:text-gray-100">
            <GroupForm :form="form"/>
        </div>

        <div class="flex justify-end gap-2 py-3 px-4 dark:bg-slate-900">
            <button @click="closeModal"
                    class="text-gray-800 dark:text-slate-100 flex gap-1 items-center justify-center bg-gray-100 dark:bg-slate-950 rounded-md hover:bg-gray-200 dark:hover:bg-slate-800 py-2 px-4">
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
