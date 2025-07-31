<script setup>
import { ref } from 'vue';
const postCreateing = ref(false);
</script>

<template>
    <div class="py-6">
        <div @click="postCreating = true" class="py-3 px-3 border border-gray-300 rounded mb-3">
            Click here to create a post
        </div>
        <div v-if="postCreating" class="felx gap-2 justify-between">
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 relative">Attach Files
                <input type="file" class="absolute left-0 top-0 right-0 bottom-0 opacity-0  " />
            </button>؛
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
        </div>
    </div>
</template>

<style scoped>

</style>
