<script setup>
import PostItem from '@/Components/app/PostItem.vue';

defineProps({
    posts: Array,
});

</script>

<template>
    <div class="overflow-auto">
        <PostItem v-for="post of posts" :post="post" />
    </div>
</template>

<style scoped>

</style>
