<script setup lang="ts">
defineProps({
    post: {
        type: Object,
        required: true,
    },
    showTime: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <div class="flex items-center gap-2">
        <a href="javascript:void(0)">
            <img :src="post.user.avatar_url"
                 class="w-[40px] rounded-full border-2 transition-all hover:border-blue-500"/>
        </a>
        <div>
            <a href="javascript:void(0)">
                <h4 class="text-lg font-bold">
                    <a href="javascript:void(0)" class="hover:underline">{{ post.user.name }}</a>
                    <template v-if="post.group">
                        <a href="javascript:void(0)" class="hover:underline">{{ post.group.name }}</a>
                    </template>
                </h4>
            </a>
            <small v-if="showTime" class="text-gray-400">{{ post.updated_at }}</small>
        </div>
    </div>
</template>

<style scoped>

</style>
