<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { ChatBubbleLeftRightIcon, HandThumbUpIcon } from '@heroicons/vue/24/outline'
import { router } from "@inertiajs/vue3";
import axiosClient from "@/axiosClient.js";
import PostUserHeader from "@/Components/app/PostUserHeader.vue";
import ReadMoreReadLess from "@/Components/app/ReadMoreReadLess.vue";
import EditDeleteDropdown from "@/Components/app/EditDeleteDropdown.vue";
import CommentList from "@/Components/app/CommentList.vue";
import PostAttachments from "@/Components/app/PostAttachments.vue";

const props = defineProps({
    post: Object,
})

const emit = defineEmits(['editClick', 'attachmentClick']);

function openEditModal() {
    emit('editClick', props.post);
}

function openAttachment(ind) {
    emit('attachmentClick', props.post, ind);
}

function sendReaction() {
    axiosClient.post(route('post.reaction', props.post), {
        reaction: 'like',
    })
        .then(({ data }) => {
            props.post.current_user_has_reaction = data.current_user_has_reaction;
            props.post.num_of_reactions = data.num_of_reactions;
        })
}

function deletePost() {
    if (window.confirm('Are you sure you want to delete this post?')) {
        router.delete(route('post.destroy', props.post), {
            preserveScroll: true,
        })
    }
}
</script>

<template>
    <div class="bg-white p-4 rounded mb-4">
        <div class="flex items-center justify-between gap-2 mb-3">
            <PostUserHeader :post="post"/>
            <EditDeleteDropdown :user="post.user" @edit="openEditModal" @delete="deletePost" />
        </div>
        <div class="mb-3">
            <ReadMoreReadLess :content="post.body" />
        </div>
        <div class="grid gap-3 mb-3" :class="[
                post.attachments.length === 1 ? 'grid-cols-1' : 'grid-cols-2'
            ]">
            <PostAttachments :attachments="post.attachments" @attachmentClick="openAttachment"/>
        </div>
        <!--   Likes & comments     -->
        <Disclosure v-slot="">
            <div class="flex gap-2">
                <button
                    @click="sendReaction"
                    class="flex gap-1 items-center justify-center px-4 py-2 flex-1 text-gray-800 rounded-lg"
                    :class="post.current_user_has_reaction ? 'bg-sky-100 hover:bg-sky-200' : 'bg-gray-100 hover:bg-gray-200'"
                >
                    <HandThumbUpIcon class="w-5 h-5"/>
                    <span class="mr-2">{{post.num_of_reactions}}</span>
                    {{post.current_user_has_reaction ? 'Unlike' : 'Like'}}
                </button>
                <DisclosureButton
                    class="flex gap-1 items-center justify-center px-4 py-2 flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg"
                >
                    <ChatBubbleLeftRightIcon class="w-5 h-5 mr-2"/>
                    <span class="mr-2">{{post.num_of_comments}}</span>
                    Comments
                </DisclosureButton>
        </div>
            <DisclosurePanel class="comment-list mt-3 max-h-[400px] overflow-auto">
                <CommentList :post="post" :data="{comments: post.comments}" />
            </DisclosurePanel>
        </Disclosure>
    </div>
</template>
