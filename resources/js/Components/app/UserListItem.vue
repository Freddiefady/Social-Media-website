<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    user: Object,
    forApprove: {
        type: Boolean,
        default: false,
    },
    showRoleDropDown: {
        type: Boolean,
        default: false,
    },
    disableRoleDropDown: {
        type: Boolean,
        default: false,
    }
});

defineEmits(['approve', 'rejected', 'roleChange', 'delete']);
</script>

<template>
    <div class="mb-3 cursor-pointer border-2 border-transparent hover:border-indigo-500 bg-white transition-all">
        <div class="flex items-center gap-2 py-2 px-3">
            <Link :href="route('profile', user.username)">
                <img :src="user.avatar_url" class="w-[32px] rounded-full"  :alt="user.name"/>
            </Link>
            <div class="flex justify-between flex-1">
                <Link :href="route('profile', user.username)">
                    <h3 class="font-black hover:underline">{{ user.name }}</h3>
                </Link>
                <div v-if="forApprove" class="flex gap-1">
                    <button class="text-xs py-1 px-2 rounded bg-emerald-500 hover:bg-emerald-600 text-white"
                           @click.prevent.stop="$emit('approve', user)">
                        Approved
                    </button>
                    <button class="text-xs py-1 px-2 rounded bg-red-500 hover:bg-red-600 text-white"
                            @click.prevent.stop="$emit('rejected', user)">
                        Rejected
                    </button>
                </div>
                <div v-if="showRoleDropDown">
                    <select @change="$emit('roleChange', user, $event.target.value)"
                            :disabled="disableRoleDropDown"
                            class="rounded-md border-0 py-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 max-w-sm text-sm leading-6">
                        <option :selected="user.role === 'admin'">admin</option>
                        <option :selected="user.role === 'user'">user</option>
                    </select>
                    <button @click="$emit('delete', user)"
                            class="text-xs py-1.5 px-2 rounded bg-gray-700 hover:bg-gray-800 text-white disabled:bg-gray-500 ml-3"
                            :disabled="disableRoleDropDown">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style></style>
