<script setup>
import PostItem from '@/Components/app/PostItem.vue';
import {ref} from "vue";
import PostModal from "@/Components/app/PostModal.vue";

const showEditModal = ref(false);
const editPost = ref({});

defineProps({
    posts: Array,
});

function openEditModal(post) {
    editPost.value = post;
    showEditModal.value = true;
}
</script>

<template>
    <div class="overflow-auto">
        <PostItem v-for="post of posts" :post="post" @editClick="openEditModal"/>

        <PostModal :post="editPost" v-model="showEditModal"/>
    </div>

</template>

<style scoped>

</style>
