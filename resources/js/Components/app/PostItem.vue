<script setup>
import {Menu, MenuButton, MenuItems, MenuItem, Disclosure, DisclosureButton, DisclosurePanel} from '@headlessui/vue'
import {PencilIcon, TrashIcon, EllipsisVerticalIcon} from '@heroicons/vue/20/solid'
import {ChatBubbleLeftRightIcon, HandThumbUpIcon, ArrowDownTrayIcon, PaperClipIcon} from '@heroicons/vue/24/outline'
import PostUserHeader from "@/Components/app/PostUserHeader.vue";
import {router} from "@inertiajs/vue3";
import {isImage} from "@/helpers.js";
import axiosClient from "@/axiosClient.js";

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
        .then(({data}) => {
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
            <Menu as="div" class="relative inline-block text-left z-50">
                <div>
                    <MenuButton
                        class="w-8 h-8 rounded-full hover:bg-black/5 transition flex items-center justify-center"
                    >
                        <EllipsisVerticalIcon
                            class="h-5 w-5"
                            aria-hidden="true"
                        />
                    </MenuButton>
                </div>

                <transition
                    enter-active-class="transition duration-100 ease-out"
                    enter-from-class="transform scale-95 opacity-0"
                    enter-to-class="transform scale-100 opacity-100"
                    leave-active-class="transition duration-75 ease-in"
                    leave-from-class="transform scale-100 opacity-100"
                    leave-to-class="transform scale-95 opacity-0"
                >
                    <MenuItems
                        class="absolute right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                    >
                        <div class="px-1 py-1">
                            <MenuItem v-slot="{ active }">
                                <button
                                    @click="openEditModal"
                                    :class="[
                                          active ? 'bg-indigo-500 text-white' : 'text-gray-900',
                                          'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                    ]"
                                >
                                    <PencilIcon
                                        class="mr-2 h-5 w-5"
                                        aria-hidden="true"
                                    />
                                    Edit
                                </button>
                            </MenuItem>
                        </div>
                        <div class="px-1 py-1">
                            <MenuItem v-slot="{ active }">
                                <button
                                    @click="deletePost"
                                    :class="[
                                      active ? 'bg-indigo-500 text-white' : 'text-gray-900',
                                      'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                    ]"
                                >
                                    <TrashIcon
                                        class="mr-2 h-5 w-5"
                                        aria-hidden="true"
                                    />
                                    Delete
                                </button>
                            </MenuItem>
                        </div>
                    </MenuItems>
                </transition>
            </Menu>
        </div>
        <div>
            <Disclosure v-slot="{ open }">
                <div v-if="!open" v-html="post.body?.substring(0, 200)"/>
                <template v-if="post.body?.length > 200">
                    <DisclosurePanel>
                        <div v-html="post.body"/>
                    </DisclosurePanel>
                    <div class="flex justify-end">
                        <DisclosureButton class="text-blue-500 hover:underline">
                            {{ open ? 'Show Less' : 'Show More' }}
                        </DisclosureButton>
                    </div>
                </template>
            </Disclosure>
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

                    <img v-if="isImage(attachment)" :src="attachment.url" class="object-contain aspect-square"/>

                    <div v-else class="flex items-center justify-center">
                        <PaperClipIcon class="w-4 h-4 mr-2"/>
                        <small>{{ attachment.name }}</small>
                    </div>
                </div>
            </template>
        </div>
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
            <button
                class="flex gap-1 items-center justify-center px-4 py-2 flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg">
                <ChatBubbleLeftRightIcon class="w-5 h-5 mr-2"/>
                Comment
            </button>
        </div>
    </div>
</template>

<style lang="scss" scoped></style>
