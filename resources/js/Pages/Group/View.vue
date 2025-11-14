<script setup>
import { Tab, TabGroup, TabList, TabPanel, TabPanels } from '@headlessui/vue'
import { useForm, usePage } from '@inertiajs/vue3';
import { CameraIcon, CheckCircleIcon, XMarkIcon } from '@heroicons/vue/24/solid'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TabItem from "@/Pages/Profile/Partials/TabItem.vue";
import TabPhoto from "@/Pages/Profile/TabPhoto.vue";
import { computed, ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InviteUserModal from "@/Components/app/InviteUserModal.vue";
import UserListItem from "@/Components/app/UserListItem.vue";
import TextInput from "@/Components/TextInput.vue";
import GroupForm from "@/Components/app/GroupForm.vue";
import PostList from "@/Components/app/PostList.vue";
import CreatePost from "@/Components/app/CreatePost.vue";

const imagesForm = useForm({
    thumbnail: null,
    cover: null,
})

const showNotification = ref(true);
const coverImageScr = ref(null);
const thumbnailImageScr = ref(null);
const showInviteUserModal = ref(false);
const searchKeyword = ref('');

const authUser = usePage().props.auth.user;

const isCurrentUserAdmin = computed(() => props.group.role === 'admin');
const isJoinedToGroup = computed(() => props.group.role && props.group.status === 'approved');

const props = defineProps({
    errors: Object,
    success: {
        type: String,
    },
    group: {
        type: Object,
    },
    posts: Object,
    users: Array,
    requests: Array,
    photos: Array,
});

const aboutForm = useForm({
    name: usePage().props.group.name,
    auto_approval: !! parseInt(usePage().props.group.auto_approval),
    about: usePage().props.group.about.replace(/<br\s*\/?>/gi, '\n'),
})

function onCoverChange(event) {
    imagesForm.cover = event.target.files[0];
    if (imagesForm.cover) {
        const reader = new FileReader();
        reader.onload = () => {
            coverImageScr.value = reader.result;
        }
        reader.readAsDataURL(imagesForm.cover);
    }
}

function onThumbnailChange(event) {
    imagesForm.thumbnail = event.target.files[0];
    if (imagesForm.thumbnail) {
        const reader = new FileReader();
        reader.onload = () => {
            thumbnailImageScr.value = reader.result;
        }
        reader.readAsDataURL(imagesForm.thumbnail);
    }
}

function cancelCoverImage() {
    imagesForm.cover = null;
    coverImageScr.value = null;
}

function cancelThumbnailImage() {
    imagesForm.thumbnail = null;
    thumbnailImageScr.value = null;
}

function submitCoverImage() {
    imagesForm.post(route('group.update-images', props.group.slug), {
        preserveScroll: true,
        onSuccess: () => {
            showNotification.value = true;
            cancelCoverImage()
            setTimeout(() => {
                showNotification.value = false;
            }, 3000);
        },
    });
}

function submitThumbnailImage() {
    imagesForm.post(route('group.update-images', props.group.slug), {
        preserveScroll: true,
        onSuccess: () => {
            showNotification.value = true;
            cancelThumbnailImage()
            setTimeout(() => {
                showNotification.value = false;
            }, 3000);
        },
    });
}

function joinToGroup() {
    const form = useForm({})

    form.post(route('group.join', props.group.slug), {
        preserveScroll: true,
    })
}

function approveUser(user) {
    const form = useForm({
        user_id: user.id,
        action: 'approved',
    })

    form.post(route('group.approve-request', props.group.slug), {
        preserveScroll: true,
    })
}

function rejectedUser(user) {
    const form = useForm({
        user_id: user.id,
        action: 'rejected',
    })

    form.post(route('group.approve-request', props.group.slug), {
        preserveScroll: true,
    })
}

function deleteUser(user){
    if (! window.confirm(`Are you sure you want to delete "${user.name}" this group?`)) return false;

    const form = useForm({
        user_id: user.id,
    })

    form.delete(route('group.destroy-user', props.group.slug), {
        preserveScroll: true,
    })
}

function onRoleChange(user, role){
    const form = useForm({
        user_id: user.id,
        role,
    })
    form.post(route('group.change-role', props.group.slug), {
        preserveScroll: true,
    })
}

function updateAbout(){
    aboutForm.put(route('group.update', props.group.slug), {
        preserveScroll: true,
    })
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-[768px] mx-auto h-full overflow-auto">
            <div class="px-4">
                <div
                    v-show="showNotification && success"
                    class="my-2 px-3 py-2 font-medium text-sm text-white bg-emerald-500"
                >
                    {{ success }}
                </div>
                <div
                    v-show="errors.cover"
                    class="my-2 px-3 py-2 font-medium text-sm text-white bg-red-500"
                >
                    {{ errors.cover }}
                </div>

                <div class="group relative bg-white">
                    <img :src="coverImageScr || group.cover_url || '/img/Desktop-BG726.webp'"
                         class="w-full h-[200px] object-cover" :alt="group.name"/>
                    <div v-if="isCurrentUserAdmin" class="absolute top-2 right-2">
                        <button v-if="!coverImageScr"
                                class="bg-gray-50 hover:bg-gray-100 text-gray-800 text-xs py-1 px-2 flex items-center opacity-0 group-hover:opacity-100"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-3 h-3 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z"/>
                            </svg>
                            Upload Cover Image
                            <input type="file" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer"
                                   @change="onCoverChange"/>
                        </button>
                        <div v-else class="flex gap-2 bg-white p-2 opacity-0 group-hover:opacity-100">
                            <button
                                @click="cancelCoverImage"
                                class="bg-gray-50 hover:bg-gray-100 text-gray-800 text-xs py-1 px-2 flex items-center">
                                <XMarkIcon class="w-3 h-3 mr-2"/>
                                Cancel
                            </button>
                            <button
                                @click="submitCoverImage"
                                class="bg-gray-800 hover:bg-gray-900 text-gray-100 text-xs py-1 px-2 flex items-center">
                                <CheckCircleIcon class="w-3 h-3 mr-2"/>
                                Submit
                            </button>
                        </div>
                    </div>

                    <div class="flex">
                        <div
                            class="flex items-center justify-center relative group/thumbnail -mt-[64px] ml-[48px] h-[128px] w-[128px] rounded-full">
                            <img :src="thumbnailImageScr || group.thumbnail_url"
                                 class="w-full h-full object-cover rounded-full" :alt="group.name"/>
                            <button
                                v-if="isCurrentUserAdmin && !thumbnailImageScr"
                                class="absolute left-0 top-0 right-0 bottom-0 flex items-center justify-center text-gray-200 rounded-full bg-black/50 text-xs py-1 px-2 opacity-0 group-hover/thumbnail:opacity-100"
                            >
                                <CameraIcon class="w-8 h-8"/>
                                <input type="file"
                                       class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer"
                                       @change="onThumbnailChange"/>
                            </button>
                            <div v-else-if="isCurrentUserAdmin" class="absolute top-1 right-0 flex flex-col gap-2">
                                <button
                                    @click="cancelThumbnailImage"
                                    class="w-7 h-7 flex items-center justify-center bg-red-500/80 text-white rounded-full">
                                    <XMarkIcon class="w-5 h-5"/>
                                </button>
                                <button
                                    @click="submitThumbnailImage"
                                    class="w-7 h-7 flex items-center justify-center bg-emerald-500/80 text-white rounded-full">
                                    <CheckCircleIcon class="w-5 h-5"/>
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-between items-center flex-1 p-4">
                            <h2 class="text-bold text-lg">{{ group.name }}</h2>
                            <primary-button :href="route('login')" v-if="! authUser">
                                login to join to group
                            </primary-button>
                            <PrimaryButton v-if="isCurrentUserAdmin"
                                           @click="showInviteUserModal = true">
                                Invite Users
                            </PrimaryButton>
                            <PrimaryButton v-if="authUser && ! group.role && group.auto_approval"
                                           @click="joinToGroup">
                                Join to Group
                            </PrimaryButton>
                            <PrimaryButton v-if="authUser && !group.role && !group.auto_approval"
                                           @click="joinToGroup">
                                Request to join
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t p-4 pt-0">
                <TabGroup>
                    <TabList class="pl-lg-[200px] flex bg-white">
                        <Tab v-slot="{ selected }" as="template">
                            <TabItem text="Posts" :selected="selected"/>
                        </Tab>
                        <Tab v-if="isJoinedToGroup" v-slot="{ selected }" as="template">
                            <TabItem text="Users" :selected="selected"/>
                        </Tab>
                        <Tab v-if="isCurrentUserAdmin" v-slot="{ selected }" as="template">
                            <TabItem text="Pending Requests" :selected="selected"/>
                        </Tab>
                        <Tab v-slot="{ selected }" as="template">
                            <TabItem text="Photos" :selected="selected"/>
                        </Tab>
                        <Tab v-slot="{ selected }" as="template">
                            <TabItem text="About" :selected="selected"/>
                        </Tab>
                    </TabList>

                    <TabPanels class="mt-2">
                        <TabPanel>
                            <template v-if="posts">
                                <CreatePost :group="group"/>
                                <PostList v-if="posts.data.length" :posts="posts.data" class="flex-1" />
                                <div v-else class="text-center py-8">
                                    There are no posts in this group. Be the first and create it.
                                </div>
                            </template>
                            <div v-else class="py-8 text-center">
                                You don't have permission to view these posts.
                            </div>
                        </TabPanel>
                        <TabPanel v-if="isJoinedToGroup">
                            <div class="mb-3">
                                <TextInput :model-value="searchKeyword" placeholder="Type to search" class="w-full"/>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <UserListItem v-for="user of users" :user="user" :key="user.id"
                                              class="shadow rounded-lg"
                                              :show-role-drop-down="isCurrentUserAdmin"
                                              :disable-role-drop-down="group.user_id === user.id"
                                              @role-change="onRoleChange"
                                              @delete="deleteUser"/>
                            </div>
                        </TabPanel>
                        <TabPanel v-if="isCurrentUserAdmin">
                            <div v-if="requests.length" class="grid grid-cols-2 gap-3">
                                <UserListItem v-for="user of requests" :user="user" :key="user.id"
                                              class="shadow rounded-lg"
                                              :for-approve="true"
                                              @approve="approveUser"
                                              @rejected="rejectedUser"/>
                            </div>

                            <div v-else class="py-8 text-center">
                                There are no pending requests.
                            </div>
                        </TabPanel>
                        <TabPanel class='bg-white p-3 shadow'>
                            <TabPhoto :photos="photos"/>
                        </TabPanel>
                        <TabPanel class='bg-white p-3 shadow'>
                            <template v-if="isCurrentUserAdmin">
                                <GroupForm :form="aboutForm" />
                                <primary-button @click="updateAbout">Submit</primary-button>
                            </template>
                            <div v-else v-html="group.about">

                            </div>
                        </TabPanel>
                    </TabPanels>
                </TabGroup>
            </div>
        </div>
    </AuthenticatedLayout>
    <InviteUserModal v-model="showInviteUserModal"/>
</template>

<style lang="scss" scoped></style>
