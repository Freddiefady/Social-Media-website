<script setup>
import {Disclosure, DisclosureButton, DisclosurePanel} from '@headlessui/vue'
import {ChatBubbleLeftRightIcon, HandThumbUpIcon, ArrowDownTrayIcon, PaperClipIcon} from '@heroicons/vue/24/outline'
import PostUserHeader from "@/Components/app/PostUserHeader.vue";
import { router, usePage } from "@inertiajs/vue3";
import {isImage} from "@/helpers.js";
import axiosClient from "@/axiosClient.js";
import InputTextArea from "@/Components/InputTextArea.vue";
import IndigoButton from "@/Components/app/IndigoButton.vue";
import { ref } from "vue";
import ReadMoreReadLess from "@/Components/app/ReadMoreReadLess.vue";
import EditDeleteDropdown from "@/Components/app/EditDeleteDropdown.vue";

const props = defineProps({
    post: Object,
})

const authUser = usePage().props.auth.user;

const editingComment = ref(null);

const newCommentText = ref('');

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
        .then(({data}) => {
            props.post.current_user_has_reaction = data.current_user_has_reaction;
            props.post.num_of_reactions = data.num_of_reactions;
        })
}

function createComment(){
    axiosClient.post(route('post.comment.store', props.post), {
        comment: newCommentText.value,
    })
        .then(({data}) => {
            newCommentText.value = ''
            props.post.comments.unshift(data)
            props.post.num_of_comments++;
        })
}

function deleteComment(comment) {
    if (! window.confirm("Are you sure you want to delete this post?")) {
        return;
    }
    axiosClient.delete(route('post.comment.destroy', comment.id))
    .then(() => {
        props.post.comments = props.post.comments.filter(c => c.id !== comment.id)
        props.post.num_of_comments--;
    })
}

function startCommentEdit(comment) {
    editingComment.value = {
        id: comment.id,
        comment: comment.comment.replace(/<br\s*\/?>/gi, '\n') // <br />
    }
}

function updateComment() {
    axiosClient.put(route('post.comment.update', editingComment.value.id), editingComment.value)
        .then(({data}) => {
            editingComment.value = null
            props.post.comments = props.post.comments.map((c) => {
                if (c.id === data.id) {
                    return data;
                }
                return c;
            })
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
            <template v-for="(attachment, ind) of post.attachments.slice(0, 4)">
                <div @click="openAttachment(ind)"
                    class="group bg-blue-100 aspect-square flex flex-col items-center justify-center text-gray-500 relative cursor-pointer">

                    <div v-if="ind === 3 && post.attachments.length > 4"
                         class="absolute top-0 left-0 right-0 bottom-0 z-10 bg-black/30 text-white flex items-center justify-center text-2xl">
                        +{{ post.attachments.length - 4 }} more
                    </div>

                    <!-- Download -->
                    <a @click.stop :href="route('post.download', attachment)"
                       class="z-20 w-8 h-8 flex flex-col items-center justify-center rounded bg-gray-700 hover:bg-gray-800 text-gray-100 absolute right-2 top-2 cursor-pointer group opacity-0 group-hover:opacity-100 transition-all">
                        <ArrowDownTrayIcon class="w-4 h-4"/>
                    </a>
                    <!-- /Download -->

                    <img v-if="isImage(attachment)" :src="attachment.url" class="object-contain aspect-square" alt=""/>

                    <div v-else class="flex items-center justify-center">
                        <PaperClipIcon class="w-4 h-4 mr-2"/>
                        <small>{{ attachment.name }}</small>
                    </div>
                </div>
            </template>
        </div>
        <Disclosure v-slot="{ open }">
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

                </DisclosureButton>
        </div>
            <DisclosurePanel class="mt-3">
                <div class="flex gap-2 mb-3">
                    <a href="javascript:void(0)">
                        <img :src="authUser.avatar_url"
                             class="w-[40px] rounded-full border-2 transition-all hover:border-blue-500" alt=""/>
                    </a>
                    <div class="flex flex-1">
                        <InputTextArea v-model="newCommentText" placeholder="Enter your comment here" rows="1" class="w-full max-h-[160px] resize-none rounded-r-none"></InputTextArea>
                        <IndigoButton @click="createComment" class="rounded-l-none w-[100px] max-w-[100px]">Submit</IndigoButton>
                    </div>
                </div>
                <div>
                    <div v-for="comment of post.comments" :key="comment.id" class="mb-4">
                        <div class="flex justify-between gap-2">
                            <div class="flex gap-2">
                                <a href="javascript:void(0)">
                                    <img :src="comment.user.avatar_url"
                                         class="w-[40px] rounded-full border-2 transition-all hover:border-blue-500" alt=""/>
                                </a>
                                <div>
                                    <h4 class="font-bold">
                                        <a href="javascript:void(0)" class="hover:underline">
                                            {{ comment.user.name }}
                                        </a>
                                    </h4>
                                    <small class="text-xs text-gray-400">{{ comment.updated_at }}</small>
                                </div>
                            </div>
                            <EditDeleteDropdown :user="comment.user" @edit="startCommentEdit(comment)" @delete="deleteComment(comment)" />
                        </div>
                        <div v-if="editingComment && editingComment.id === comment.id" class="ml-12">
                            <InputTextArea v-model="editingComment.comment" rows="1" class="w-full max-h-[160px] resize-none"></InputTextArea>
                            <div class="flex gap-2 justify-end">
                                <button @click="editingComment = null" class="rounded-r-none text-indigo-500">cancel</button>
                                <IndigoButton @click="updateComment" class="w-[100px]">update</IndigoButton>
                            </div>
                        </div>
                        <ReadMoreReadLess v-else :content="comment.comment" content-class="text-sm flex flex-1 ml-12"/>
                    </div>
                </div>
            </DisclosurePanel>
        </Disclosure>
    </div>
</template>

<style lang="scss" scoped></style>
