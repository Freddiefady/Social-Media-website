<script setup>
import TextInput from "@/Components/TextInput.vue";
import GroupItem from "@/Components/app/GroupItem.vue";
import GroupModal from "@/Components/app/GroupModal.vue";
import { ref } from "vue";

const searchKeyword = ref("");
const showNewGroupModal = ref(false)

const props = defineProps({
    groups: Array,
})

function onGroupCreate(data){
    props.groups.unshift(data)
}
</script>

<template>
    <div class="flex gap-2 mt-4">
        <TextInput :model-value="searchKeyword" placeholder="Type to search" class="w-full" />
        <button @click="showNewGroupModal = true" class="text-xs bg-indigo-500 hover:bg-indigo-600 text-white dark:text-gray-100 py-1 px-2 rounded">
            New Group
        </button>
    </div>
    <div class="mt-3 h-[200px] lg:flex-1 overflow-auto">
        <div v-if="false" class="text-gray-400 dark:text-gray-100 flex justify-center p-3">
            you are not a member of any groups.
        </div>
        <div v-else>
            <GroupItem v-for="group in groups" :group="group" />
        </div>
    </div>
    <GroupModal v-model="showNewGroupModal"  @create="onGroupCreate"/>
</template>

<style scoped></style>
