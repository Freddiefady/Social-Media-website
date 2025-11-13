<script setup>
import { ArrowDownTrayIcon } from '@heroicons/vue/24/outline'
import { PaperClipIcon } from '@heroicons/vue/24/solid'
import { isImage } from "@/helpers.js";
import AttachmentPreviewModal from '@/Components/app/AttachmentPreviewModal.vue';
import { ref } from 'vue';

defineProps({
    photos: Array,
});

const currentPhotoIndex = ref(0);
const showModal = ref(false);

function openPhoto(index) {
    currentPhotoIndex.value = index;
    showModal.value = true;
}
</script>

<template>
<div class="grid gap-2 grid-cols-2 sm:grid-cols-3">
    <template v-for="(attachment, ind) of photos">
        <div @click="openPhoto(ind)" class="group bg-blue-100 aspect-square flex flex-col items-center justify-center text-gray-500 relative cursor-pointer">

            <!-- Download -->
            <a @click.stop :href="route('post.download', attachment)" class="z-20 w-8 h-8 flex flex-col items-center justify-center rounded bg-gray-700 hover:bg-gray-800 text-gray-100 absolute right-2 top-2 cursor-pointer group opacity-0 group-hover:opacity-100 transition-all">
                <ArrowDownTrayIcon class="w-4 h-4" />
            </a>
            <!-- /Download -->
            <img v-if="isImage(attachment)" :src="attachment.url" class="object-contain aspect-square" alt="" />

            <div v-else class="flex items-center justify-center">
                <PaperClipIcon class="w-4 h-4 mr-2" />
                <small>{{ attachment.name }}</small>
            </div>
        </div>
    </template>

    <AttachmentPreviewModal :attachments="photos || []" v-model:index="currentPhotoIndex" v-model="showModal" />
</div>
</template>

<style>
</style>
