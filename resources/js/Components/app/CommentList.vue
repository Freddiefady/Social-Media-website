<script setup>
import InputTextArea from "@/Components/InputTextArea.vue";
import { ChatBubbleLeftEllipsisIcon, HandThumbUpIcon } from "@heroicons/vue/24/outline/index.js";
import IndigoButton from "@/Components/app/IndigoButton.vue";
import ReadMoreReadLess from "@/Components/app/ReadMoreReadLess.vue";
import EditDeleteDropdown from "@/Components/app/EditDeleteDropdown.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import axiosClient from "@/axiosClient.js";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";

const authUser = usePage().props.auth.user;

const editingComment = ref(null);

const newCommentText = ref('');

const props = defineProps({
    post: Object,
    data: Object,
    parentComment: {
        type: [Object, null],
        default: null,
    },
})

const emit = defineEmits([
    'commentCreate', 'commentDelete'
]);

function createComment() {
    axiosClient.post(route('comment.store', props.post), {
        comment: newCommentText.value,
        parent_id: props.parentComment?.id || null,
    })
        .then(({ data }) => {
            newCommentText.value = ''
            props.data.comments.unshift(data)
            if (props.parentComment) {
                props.parentComment.num_of_comments++;
            }
            props.post.num_of_comments++;
            emit('commentCreate', data);
        })
}

function startCommentEdit(comment) {
    editingComment.value = {
        id: comment.id,
        comment: comment.comment.replace(/<br\s*\/?>/gi, '\n') // <br />
    }
}

function updateComment() {
    axiosClient.put(route('comment.update', editingComment.value.id), editingComment.value)
        .then(({ data }) => {
            editingComment.value = null
            props.data.comments = props.data.comments.map((c) => {
                if (c.id === data.id) {
                    return data;
                }
                return c;
            })
        })
}

function deleteComment(comment) {
    if (!window.confirm("Are you sure you want to delete this post?")) {
        return;
    }
    axiosClient.delete(route('comment.destroy', comment.id))
        .then(() => {
            const commentIndex = props.data.comments.findIndex(c => c.id === comment.id)
            props.data.comments.splice(commentIndex, 1)
            if (props.parentComment) {
                props.parentComment.num_of_comments--;
            }
            props.post.num_of_comments--;
            emit('commentDeleted', comment);
        })
}

function sendCommentReaction(comment) {
    axiosClient.post(route('comment.reaction', comment.id), {
        reaction: 'like',
    })
        .then(({ data }) => {
            comment.current_user_has_reaction = data.current_user_has_reaction;
            comment.num_of_reactions = data.num_of_reactions;
        })
}

function onCreateComment(comment) {
    if (props.parentComment) {
        props.parentComment.num_of_comments++;
    }
    emit("commentCreate", comment);
}

function onDeleteComment(comment) {
    if (props.parentComment) {
        props.parentComment.num_of_comments--;
    }
    emit("commentDelete", comment);
}
</script>

<template>
    <div class="flex gap-2 mb-3">
        <Link :href="route('profile', authUser.name)">
            <img :src="authUser.avatar_url"
                 class="w-[40px] rounded-full border-2 transition-all hover:border-blue-500" alt=""/>
        </Link>
        <div class="flex flex-1">
            <InputTextArea v-model="newCommentText" placeholder="Enter your comment here" rows="1"
                           class="w-full max-h-[160px] resize-none rounded-r-none"></InputTextArea>
            <IndigoButton @click="createComment" class="rounded-l-none w-[100px] max-w-[100px]">Submit</IndigoButton>
        </div>
    </div>
    <div>
        <div v-for="comment of data.comments" :key="comment.id" class="mb-4">
            <div class="flex justify-between gap-2">
                <div class="flex gap-2">
                    <Link :href="route('profile', comment.user.name)">
                        <img
                            :src="comment.user?.avatar_url || '/default-avatar.png'"
                            class="w-[40px] rounded-full border-2 transition-all hover:border-blue-500"
                            :alt="comment.user?.name || 'User'"
                        />
                    </Link>
                    <div>
                        <h4 class="font-bold">
                            <Link :href="route('profile', comment.user.name)" class="hover:underline dark:text-gray-200">
                                {{ comment.user?.name || 'Unknown User' }}
                            </Link>
                        </h4>
                        <small class="text-xs text-gray-400">{{ comment.updated_at }}</small>
                    </div>
                </div>
                <EditDeleteDropdown :user="comment.user" :post="post" :comment="comment"
                                    @edit="startCommentEdit(comment)"
                                    @delete="deleteComment(comment)"/>
            </div>
            <div class="pl-12">
                <div v-if="editingComment && editingComment.id === comment.id">
                    <InputTextArea v-model="editingComment.comment" rows="1"
                                   class="w-full max-h-[160px] resize-none"></InputTextArea>
                    <div class="flex gap-2 justify-end">
                        <button @click="editingComment = null" class="rounded-r-none text-indigo-500">cancel</button>
                        <IndigoButton @click="updateComment" class="w-[100px]">update</IndigoButton>
                    </div>
                </div>
                <ReadMoreReadLess v-else :content="comment.comment" content-class="text-sm flex flex-1 dark:text-gray-100"/>
                <Disclosure>
                    <div class="flex gap-2 mt-1">
                        <button @click="sendCommentReaction(comment)"
                                class="flex items-center text-xs text-indigo-500 p-1 rounded-lg px-1 py-0.5"
                                :class="comment.current_user_has_reaction ? 'bg-indigo-50 hover:bg-indigo-100' : 'hover:bg-indigo-50'"
                        >
                            <HandThumbUpIcon class="w-3 h-3 mr-1"/>
                            <span class="mr-2">{{ comment.num_of_reactions }}</span>
                            {{ comment.current_user_has_reaction ? 'unlike' : 'like' }}
                        </button>
                        <DisclosureButton
                            class="flex items-center text-xs text-indigo-500 p-1 hover:bg-indigo-100 rounded-lg px-1 py-0.5">
                            <ChatBubbleLeftEllipsisIcon class="w-3 h-3 mr-1"/>
                            <span class="mr-2">{{ comment.num_of_comments }}</span>
                            reply
                        </DisclosureButton>
                    </div>
                    <DisclosurePanel class="mt-3">
                        <CommentList :post="post"
                                     :data="{comments: comment.comments}"
                                     :parent-comment="comment"
                                     @comment-create="onCreateComment"
                                     @comment-delete="onDeleteComment"
                        />
                    </DisclosurePanel>
                </Disclosure>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
