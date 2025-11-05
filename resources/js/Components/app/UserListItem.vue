<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    user: Object,
    forApprove: {
        type: Boolean,
        default: false,
    }
});

defineEmits(['approve', 'rejected'])
</script>

<template>
    <div class="mb-3 cursor-pointer border-2 border-transparent hover:border-indigo-500 bg-white transition-all">
        <Link :href="route('profile', user.username)" class="flex items-center gap-2 py-2 px-3">
            <img :src="user.avatar_url" class="w-[32px] rounded-full"  :alt="user.name"/>
            <div class="flex justify-between flex-1">
                <h3 class="font-black">{{ user.name }}</h3>
                <div class="flex gap-1">
                    <button class="text-xs py-1 px-2 rounded bg-emerald-500 hover:bg-emerald-600 text-white"
                            v-if="forApprove" @click.prevent.stop="$emit('approve', user)">
                        Approved
                    </button>
                    <button class="text-xs py-1 px-2 rounded bg-red-500 hover:bg-red-600 text-white"
                            v-if="forApprove" @click.prevent.stop="$emit('rejected', user)">
                        Rejected
                    </button>
                </div>
            </div>
        </Link>
    </div>
</template>

<style></style>
