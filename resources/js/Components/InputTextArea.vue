<script setup>
import {onMounted, ref} from 'vue';

const model = defineModel({
    type: String,
    required: true,
    placeholder: String,
});

const props = defineProps({
    modelValue: {
        type: String,
        required: false,
    },
    placeholder: String,
    autoResize: {
        type: Boolean,
        default: true,
    },
})

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({focus: () => input.value.focus()});

function onInputChange() {
    if (props.autoResize) {
        input.value.style.height = 'auto'; // Reset height
        input.value.style.height = `${input.value.scrollHeight + 1}px`; // Set height to scrollHeight
    }
}
</script>

<template>
    <textarea
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
        v-model="model"
        ref="input"
        @input="onInputChange"
        :placeholder="placeholder"
    />
</template>
