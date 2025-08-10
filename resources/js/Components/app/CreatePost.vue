<script setup>
import { ref } from 'vue';
import InputTextArea from "@/Components/InputTextArea.vue";
import {useForm} from "@inertiajs/vue3";
const postCreating = ref(false);

const newPostForm = useForm({
    body: '',
});

function submit() {
    newPostForm.post(route('post.store'), {
        onSuccess: () => {
            newPostForm.reset();
        },
    });
}
</script>

<template>
    <div class="p-4 bg-white rounded-lg border mb-3">
        <InputTextArea @click="postCreating = true" rows="1" v-model="newPostForm.body"
                       class="mb-3 w-full" placeholder="Click here to create new post ..." />

        <div v-if="postCreating" class="flex gap-2 justify-between">
            <button type="button"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 relative">
            Attach Files
                <input type="file" class="absolute left-0 top-0 right-0 bottom-0 opacity-0" />
            </button>
            <button type="submit" @click="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Submit
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>
