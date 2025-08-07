<script setup>
import {TabGroup, TabList, Tab, TabPanels, TabPanel} from '@headlessui/vue'
import {useForm, usePage} from '@inertiajs/vue3';
import {XMarkIcon, CheckCircleIcon} from '@heroicons/vue/24/solid'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TabItem from "@/Pages/Profile/Partials/TabItem.vue";
import Edit from "@/Pages/Profile/Edit.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {computed, ref} from "vue";

const imagesForm = useForm({
    avatar: null,
    cover: null,
})

const coverImageScr = ref(null);
const authUser = usePage().props.auth.user;
const isMyProfile = computed(() => authUser && authUser.id === props.user.id)

const props = defineProps({
    errors: Object,
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    user: {
        type: Object,
    }
});

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

function cancelCoverImage() {
    imagesForm.cover = null;
    coverImageScr.value = null;
}

function submitCoverImage() {
    imagesForm.post(route('profile.update-images'), {
        onSuccess: () => {
            cancelCoverImage()
        }
    });
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-[768px] mx-auto h-full overflow-auto">
            <pre>{{ errors }}</pre>
            <div class="relative bg-white">
                <img :src="coverImageScr || user.cover_url || '/img/Desktop-BG726.webp'"
                     class="w-full h-[200px] object-cover"/>
                <div class="absolute top-2 right-2 group">
                    <button
                        class="bg-gray-50 hover:bg-gray-100 text-gray-800 text-xs py-1 px-2 flex items-center opacity-0 group-hover:opacity-100"
                        v-if="!coverImageScr">
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
                    <img src="https://konstantoulakis-chroma.gr/wp-content/uploads/2020/12/user3.jpg"
                         class="ml-[128px] h-[128px] left-[48px] -mt-[64px]"/>
                    <div class="flex justify-between items-center flex-1 p-4">
                        <h2 class="text-bold text-lg" v-if="authUser">{{ authUser.name }}</h2>
                        <PrimaryButton v-if="isMyProfile">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                 class="w-4 h-4 mr-2">
                                <path
                                    d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z"/>
                            </svg>
                            Edit Profile
                        </PrimaryButton>
                    </div>
                </div>
            </div>
            <div class="border-t">
                <TabGroup>
                    <TabList class="pl-[200px] flex bg-white">
                        <Tab v-if="isMyProfile" v-slot="{ selected }" as="template">
                            <TabItem text="About" :selected="selected"/>
                        </Tab>
                        <Tab v-slot="{ selected }" as="template">
                            <TabItem text="Posts" :selected="selected"/>
                        </Tab>
                        <Tab v-slot="{ selected }" as="template">
                            <TabItem text="Followers" :selected="selected"/>
                        </Tab>
                        <Tab v-slot="{ selected }" as="template">
                            <TabItem text="Followings" :selected="selected"/>
                        </Tab>
                        <Tab v-slot="{ selected }" as="template">
                            <TabItem text="Photos" :selected="selected"/>
                        </Tab>
                    </TabList>

                    <TabPanels class="mt-2">
                        <TabPanel v-if="isMyProfile">
                            <Edit :must-verify-email="must - verify - email" :status="status"/>
                        </TabPanel>
                        <TabPanel class='bg-white p-3 shadow'>
                            Posts Content
                        </TabPanel>
                        <TabPanel class='bg-white p-3 shadow'>
                            Followers Contnent
                        </TabPanel>
                        <TabPanel class='bg-white p-3 shadow'>
                            Followings Contnent
                        </TabPanel>
                        <TabPanel class='bg-white p-3 shadow'>
                            Photos
                        </TabPanel>
                    </TabPanels>
                </TabGroup>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="scss" scoped></style>
