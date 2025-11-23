<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { ChatBubbleLeftRightIcon, HandThumbUpIcon } from '@heroicons/vue/24/outline'
import { router, useForm, usePage } from "@inertiajs/vue3";
import axiosClient from "@/axiosClient.js";
import PostUserHeader from "@/Components/app/PostUserHeader.vue";
import ReadMoreReadLess from "@/Components/app/ReadMoreReadLess.vue";
import EditDeleteDropdown from "@/Components/app/EditDeleteDropdown.vue";
import CommentList from "@/Components/app/CommentList.vue";
import PostAttachments from "@/Components/app/PostAttachments.vue";
import { computed } from "vue";
import UrlPreview from "@/Components/app/UrlPreview.vue";

const props = defineProps({
    post: Object,
})

const group = usePage().props.group;
const authUser = usePage().props.auth.user;

const emit = defineEmits(['editClick', 'attachmentClick']);

const postBody = computed(() => {
    return props.post.body.replace(
        /(?:(\s+)|<p>)((#\w+)(?![^<]*<\/a>))/g,
        (match, group1, group2) => {
            const encode = encodeURIComponent(group2);
            return `${group1 || ''}<a href="/search/${encode}" class="hashtag">${group2}</a>`;
        });
    }
);

const isPinned = computed(() => {
    if (group?.id) {
        return group?.pinned === props.post.id
    }

    return authUser?.pinned === props.post.id;
})

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

function pinUnpinPost() {
    let isPinned = false;
    if (group?.id) {
        isPinned = group.pinned === props.post.id;
    } else {
        isPinned = authUser.pinned === props.post.id;
    }

    const form = useForm({
        forGroup: !!group?.id,
    })

    form.post(route('post.pin', props.post), {
        preserveScroll: true,
        onSuccess: () => {
            if (group?.id) {
                group.pinned = isPinned ? null : props.post.id;
            } else {
                authUser.pinned = isPinned ? null : props.post.id;
            }
        }
    })
}
</script>

<template>
    <div class="bg-white dark:bg-slate-950 p-4 rounded mb-4">
        <div class="flex items-center justify-between gap-2 mb-3">
            <PostUserHeader :post="post"/>
            <div class="flex items-center gap-1">
                <div v-if="isPinned" class="flex items-center gap-1">
                    <svg baseProfile="tiny" height="20px" id="Layer_1" version="1.2" viewBox="0 0 24 24" width="20px" class="mr-1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M16.729,4.271c-0.389-0.391-1.021-0.393-1.414-0.004c-0.104,0.104-0.176,0.227-0.225,0.355  c-0.832,1.736-1.748,2.715-2.904,3.293C10.889,8.555,9.4,9,7,9C6.87,9,6.74,9.025,6.618,9.076C6.373,9.178,6.179,9.373,6.077,9.617  c-0.101,0.244-0.101,0.52,0,0.764c0.051,0.123,0.124,0.234,0.217,0.326l3.243,3.243L5,20l6.05-4.537l3.242,3.242  c0.092,0.094,0.203,0.166,0.326,0.217C14.74,18.973,14.87,19,15,19s0.26-0.027,0.382-0.078c0.245-0.102,0.44-0.295,0.541-0.541  C15.974,18.26,16,18.129,16,18c0-2.4,0.444-3.889,1.083-5.166c0.577-1.156,1.556-2.072,3.293-2.904  c0.129-0.049,0.251-0.121,0.354-0.225c0.389-0.393,0.387-1.025-0.004-1.414L16.729,4.271z"/></svg>
                    Pinned
                </div>
            <EditDeleteDropdown :user="post.user" :post="post"
                                @edit="openEditModal" @delete="deletePost" @pin="pinUnpinPost" />
            </div>
        </div>
        <div class="mb-3 dark:text-gray-100">
            <ReadMoreReadLess :content="postBody" />
            <UrlPreview :preview="post.preview" :url="post.preview_url" />
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
                    class="flex gap-1 items-center justify-center px-4 py-2 flex-1 text-gray-800 dark:text-slate-100 rounded-lg"
                    :class="post.current_user_has_reaction
                     ? 'bg-sky-100 hover:bg-sky-200 dark:bg-sky-900 dark:hover:bg-sky-800' : 'bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-900'"
                >
                    <HandThumbUpIcon class="w-5 h-5"/>
                    <span class="mr-2">{{post.num_of_reactions}}</span>
                    {{post.current_user_has_reaction ? 'Unlike' : 'Like'}}
                </button>
                <DisclosureButton
                    class="flex gap-1 items-center justify-center px-4 py-2 flex-1 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-slate-900 text-gray-800 dark:text-gray-100 rounded-lg"
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
