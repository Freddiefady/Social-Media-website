<script setup>
import PostItem from "@/Components/app/PostItem.vue";
import PostModal from "@/Components/app/PostModal.vue";
import AttachmentPreviewModal from "@/Components/app/AttachmentPreviewModal.vue";
import {Head, usePage} from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    post: Object,
})

const authUser = usePage().props.auth.user
const showEditModal = ref(false);
const showAttachmentsModal = ref(false);
const editPost = ref({});
const previewAttachmentsPost = ref({});

function openEditModal(post) {
    editPost.value = post;
    showEditModal.value = true;
}

function openAttachmentPreviewModal(post, index) {
    previewAttachmentsPost.value = {
        post,
        index,
    };
    showAttachmentsModal.value = true;
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
    <Head :title="`Social Media - ${post.name}`" />

    <AuthenticatedLayout>
        <div class="p-8 w-[600px] mx-auto h-full overflow-auto">
            <PostItem :post="post"  @editClick="openEditModal" @attachmentClick="openAttachmentPreviewModal"/>
        </div>

        <PostModal :post="editPost" v-model="showEditModal" @hide="onModalHide"/>

        <AttachmentPreviewModal :attachments="previewAttachmentsPost.post?.attachments || []"
                                v-model:index="previewAttachmentsPost.index"
                                v-model="showAttachmentsModal"/>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
