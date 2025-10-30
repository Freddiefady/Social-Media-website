<script setup>
import { ArrowDownTrayIcon } from '@heroicons/vue/24/outline'
import { PaperClipIcon } from '@heroicons/vue/24/solid'
import { isImage } from "@/helpers.js";

defineProps({
    attachments: Array,
})

defineEmits(["attachmentClick"]);
</script>
<template>
    <template v-for="(attachment, ind) of attachments.slice(0, 4)">
        <div @click="$emit('attachmentClick', ind)"
             class="group bg-blue-100 aspect-square flex flex-col items-center justify-center text-gray-500 relative cursor-pointer">

            <div v-if="ind === 3 && attachments.length > 4"
                 class="absolute top-0 left-0 right-0 bottom-0 z-10 bg-black/30 text-white flex items-center justify-center text-2xl">
                +{{ attachments.length - 4 }} more
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
</template>
