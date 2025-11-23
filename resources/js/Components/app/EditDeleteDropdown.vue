<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { EllipsisVerticalIcon, EyeIcon, PencilIcon, TrashIcon } from "@heroicons/vue/20/solid/index.js";
import { ClipboardIcon } from "@heroicons/vue/24/outline";
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    post: {
        type: Object,
        default: null,
    },
    comment: {
        type: Object,
        default: null,
    }
});

// current post user or current comment user
const user = computed(() => props.comment?.user || props.post?.user);
//the current user id is the same the current user authenticated
const editAllowed = computed(() => user.value.id === authUser.id);

const deleteAllowed = computed(() => {
    if (user.value.id === authUser.id) return true;
    // the user owner of post is able to delete
    if (props.post?.user.id === authUser.id) return true;
    // if the comment exists and the role
    return !props.comment && props.post?.group?.role === 'admin';
})

const pinAllowed = computed(() => user.value.id === authUser.id || props.post.group && props.post.group.role === 'admin');

const isPinned = computed(() => {
    if (group?.id) {
        return group?.pinned === props.post.id
    }

    return authUser.pinned === props.post.id;
})

const authUser = usePage().props.auth.user;
const group = usePage().props.group;

defineEmits(['edit', 'delete', 'pin']);

function copyToClipboard() {
    const textToCopy = route('post.show', props.post.id);

    const tempInput = document.createElement("input");
    tempInput.value = textToCopy;
    document.body.appendChild(tempInput);

    tempInput.select();

    document.execCommand('copy');

    document.body.removeChild(tempInput);
}
</script>

<template>
    <Menu as="div" class="relative inline-block text-left dark:text-gray-100">
        <div>
            <MenuButton
                class="w-8 h-8 rounded-full z-20 hover:bg-black/5 dark:hover:text-slate-600 transition flex items-center justify-center"
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
                class="absolute z-20 right-0 mt-2 w-48 origin-top-right divide-y divide-gray-100 dark:divide-stone-800 rounded-md bg-white dark:bg-slate-900 shadow-lg ring-1 ring-black/5 dark:ring-slate-800 focus:outline-none"
            >
                <div class="px-1 py-1">
                    <MenuItem v-slot="{ active }">
                        <Link :href="route('post.show', props.post.id)"
                              :class="[
                                          active ? 'bg-indigo-500 text-white' : 'text-gray-900 dark:text-slate-100',
                                          'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                    ]"
                        >
                            <EyeIcon
                                class="mr-2 h-5 w-5"
                                aria-hidden="true"
                            />
                            Show
                        </Link>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                        <button
                            @click="copyToClipboard"
                            :class="[
                                          active ? 'bg-indigo-500 text-white' : 'text-gray-900 dark:text-slate-100',
                                          'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                    ]"
                        >
                            <ClipboardIcon
                                class="mr-2 h-5 w-5"
                                aria-hidden="true"
                            />
                            Copy To Clipboard
                        </button>
                    </MenuItem>
                    <MenuItem v-if="pinAllowed" v-slot="{ active }">
                        <button
                            @click="$emit('pin')"
                            :class="[
                                  active ? 'bg-indigo-500 text-white' : 'text-gray-900 dark:text-slate-100',
                                  'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                            ]"
                        >
                            <svg baseProfile="tiny" height="20px" id="Layer_1" version="1.2" viewBox="0 0 24 24"
                                 width="20px" class="mr-2" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M16.729,4.271c-0.389-0.391-1.021-0.393-1.414-0.004c-0.104,0.104-0.176,0.227-0.225,0.355  c-0.832,1.736-1.748,2.715-2.904,3.293C10.889,8.555,9.4,9,7,9C6.87,9,6.74,9.025,6.618,9.076C6.373,9.178,6.179,9.373,6.077,9.617  c-0.101,0.244-0.101,0.52,0,0.764c0.051,0.123,0.124,0.234,0.217,0.326l3.243,3.243L5,20l6.05-4.537l3.242,3.242  c0.092,0.094,0.203,0.166,0.326,0.217C14.74,18.973,14.87,19,15,19s0.26-0.027,0.382-0.078c0.245-0.102,0.44-0.295,0.541-0.541  C15.974,18.26,16,18.129,16,18c0-2.4,0.444-3.889,1.083-5.166c0.577-1.156,1.556-2.072,3.293-2.904  c0.129-0.049,0.251-0.121,0.354-0.225c0.389-0.393,0.387-1.025-0.004-1.414L16.729,4.271z"/></svg>
                            {{ isPinned ? 'Unpin' : 'Pin' }}
                        </button>
                    </MenuItem>
                    <MenuItem v-if="editAllowed" v-slot="{ active }">
                        <button
                            @click="$emit('edit')"
                            :class="[
                                          active ? 'bg-indigo-500 text-white' : 'text-gray-900 dark:text-slate-100',
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
                    <MenuItem v-if="deleteAllowed" v-slot="{ active }">
                        <button
                            @click="$emit('delete')"
                            :class="[
                                      active ? 'bg-indigo-500 text-white' : 'text-gray-900 dark:text-slate-100',
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
</template>

<style scoped>

</style>
