<script setup>
import PostItem from '@/Components/app/PostItem.vue';
import {ref} from "vue";
import PostModal from "@/Components/app/PostModal.vue";
import {usePage} from "@inertiajs/vue3";

const authUser = usePage().props.auth.user
const showEditModal = ref(false);
const editPost = ref({});

defineProps({
    posts: Array,
});

function openEditModal(post) {
    editPost.value = post;
    showEditModal.value = true;
}

function onModalHide() {
    editPost.value = {
        id: null,
        body: '',
        user: authUser
    }
}
</script>

<template>
    <div class="overflow-auto">
        <PostItem v-for="post of posts" :post="post" @editClick="openEditModal"/>

        <PostModal :post="editPost" v-model="showEditModal" @hide="onModalHide"/>
    </div>

</template>

<style scoped>

</style>
