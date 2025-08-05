<script setup>
import {TabGroup, TabList, Tab, TabPanels, TabPanel} from '@headlessui/vue'
import {usePage} from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TabItem from "@/Pages/Profile/Partials/TabItem.vue";
import Edit from "@/Pages/Profile/Edit.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {computed} from "vue";

const authUser = usePage().props.auth.user;
const isMyProfile = computed(() => authUser && authUser.id === props.user.id)

const props = defineProps({
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
</script>

<template>
    <AuthenticatedLayout>
        <div class="w-[768px] mx-auto h-full overflow-auto">
            <div class="relative bg-white">
                <img src="https://www.prodraw.net/fb_cover/images/fb_cover_65.jpg"
                     class="w-full h-[200px] object-cover"/>
               <div class="flex">
                   <img src="https://konstantoulakis-chroma.gr/wp-content/uploads/2020/12/user3.jpg"
                        class="ml-[128px] h-[128px] left-[48px] -mt-[64px]" />
                   <div class="flex justify-between items-center flex-1 p-4">
                       <h2 class="text-bold text-lg" v-if="authUser">{{ authUser.name }}</h2>
                       <PrimaryButton v-if="isMyProfile">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 mr-2">
                               <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
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
                           <TabItem text="About" :selected="selected" />
                        </Tab>
                        <Tab v-slot="{ selected }" as="template">
                            <TabItem text="Posts" :selected="selected" />
                        </Tab>
                        <Tab v-slot="{ selected }" as="template">
                            <TabItem text="Followers" :selected="selected" />
                        </Tab>
                        <Tab v-slot="{ selected }" as="template">
                            <TabItem text="Followings" :selected="selected" />
                        </Tab>
                        <Tab v-slot="{ selected }" as="template">
                            <TabItem text="Photos" :selected="selected" />
                        </Tab>
                    </TabList>

                    <TabPanels class="mt-2">
                        <TabPanel v-if="isMyProfile">
                           <Edit :must-verify-email="must-verify-email" :status="status" />
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
