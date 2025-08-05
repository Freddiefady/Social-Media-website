<script setup>
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <div class="space-y-6">
        <div
            class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800"
        >
            <UpdateProfileInformationForm
                :must-verify-email="mustVerifyEmail"
                :status="status"
                class="max-w-xl"
            />
        </div>

        <div
            class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800"
        >
            <UpdatePasswordForm class="max-w-xl"/>
        </div>

        <div
            class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800"
        >
            <DeleteUserForm class="max-w-xl"/>
        </div>
    </div>
</template>
