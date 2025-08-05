<script setup>
import {TabGroup, TabList, Tab, TabPanels, TabPanel} from '@headlessui/vue'
import {usePage} from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TabItem from "@/Pages/Profile/Partials/TabItem.vue";
import Edit from "@/Pages/Profile/Edit.vue";

const user = usePage().props.auth.username;

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="container mx-auto">
            <div class="relative">
                <img src="https://www.prodraw.net/fb_cover/images/fb_cover_65.jpg"
                     class="w-full h-[200px] object-cover"/>
                <img src="https://konstantoulakis-chroma.gr/wp-content/uploads/2020/12/user3.jpg"
                     class="absolute w-[128px] h-[128px] left-[48px] -bottom-[48px]">
            </div>
            <div class="sm:px-0">
                <TabGroup>
                    <TabList class="pl-[200px] flex bg-white">
                        <Tab v-slot="{ selected }" as="template">
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
                        <TabPanel key="about" class='bg-white p-3 shadow'>
                           About
                        </TabPanel>
                        <TabPanel key="posts" class='bg-white p-3 shadow'>
                            Posts Content
                        </TabPanel>
                        <TabPanel key="followers" class='bg-white p-3 shadow'>
                           Followers Contnent
                        </TabPanel>
                        <TabPanel key="followings" class='bg-white p-3 shadow'>
                           Followings Contnent
                        </TabPanel>
                        <TabPanel key="photos" class='bg-white p-3 shadow'>
                           Photos
                        </TabPanel>
                    </TabPanels>
                </TabGroup>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="scss" scoped></style>
