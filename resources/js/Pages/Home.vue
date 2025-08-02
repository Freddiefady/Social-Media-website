<script setup>
import CreatePost from '@/Components/app/CreatePost.vue';
import FollowingList from '@/Components/app/FollowingList.vue';
import GroupList from '@/Components/app/GroupList.vue';
import PostList from '@/Components/app/PostList.vue';
import { Head } from '@inertiajs/vue3';

defineProps({

});
</script>

<template>
    <Head title="Social Media" />

    <div class="grid lg:grid-cols-12 gap-3 p-4 h-full">
        <div class="lg:col-span-3 lg:order-1 overflow-hidden h-full">
            <GroupList />
        </div>
        <div class="lg:col-span-3 lg:order-3 overflow-hidden h-full">
            <FollowingList />
        </div>
        <div class="lg:col-span-6 lg:order-2 overflow-hidden h-full flex flex-col">
            <CreatePost />
            <PostList class="flex-1" />
        </div>
    </div>
</template>

<style scoped></style>
