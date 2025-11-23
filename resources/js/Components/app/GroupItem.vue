<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    group: Object,
});
</script>

<template>
    <div class="mb-3 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-800">
        <Link :href="route('group.show', group.slug)" class="flex items-start gap-1 py-2 px-3">
            <img :src="group.thumbnail_url" class="w-[32px] rounded-full" :alt="group.title"/>
            <div class="flex-1">
                <div class="flex justify-between">
                    <h3 class="font-black text-lg">{{ group.name }}</h3>
                    <span class="text-sm">
                        {{ group.status === 'approved' ? (group.role === 'admin' ? group.role : '') : 'not approved' }}
                    </span>
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400">{{ group.description }}</div>
            </div>
        </Link>
    </div>
</template>

<style></style>
