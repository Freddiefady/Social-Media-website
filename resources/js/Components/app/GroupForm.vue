<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps({
    form: Object,
})
</script>

<template>
  <div class="mt-3">
    <label>Group Name</label>
    <TextInput
        type="text"
        class="mt-1 block w-full"
        v-model="form.name"
        required
        autofocus
    />
  </div>
  <div class="mt-3">
    <Checkbox name="remember" v-model:checked="form.auto_approval"/>
    Enable Auto Approval
  </div>
  <div class="mt-3">
    <label>About Group</label>
    <textarea v-model="form.about" class="w-full"></textarea>
  </div>
</template>
