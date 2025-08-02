<script setup>
import PostItem from '@/Components/PostItem.vue';

const post1 = {
    user: {
        id: 1,
        avatar: 'https://randomuser.me/api/portraits/men/79.jpg',
        name: 'John Doe',
    },
    attachments: [
        {
            id: 1,
            name: 'test1.png',
            url: 'https://picsum.photos/1000',
            mime: 'image/jpeg',
        },
        {
            id: 2,
            name: 'test2.png',
            url: 'https://picsum.photos/1000',
            mime: 'image/jpeg',
        },
        {
            id: 3,
            name: 'document.docx',
            url: '#',
            mime: 'application/docx',
        },
    ],
    group: null,
    body: `
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus neque alias necessitatibus soluta iste aut animi corporis? Voluptate totam aperiam, praesentium necessitatibus magnam officiis aliquid rem nobis fuga inventore consequatur.</p>

    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus neque alias necessitatibus soluta iste aut animi corporis? Voluptate totam aperiam, praesentium necessitatibus magnam officiis aliquid rem nobis fuga inventore consequatur.</p>`,
    created_at: '2023-10-01 12:00:00',
};
const post2 = {
    user: {
        id: 1,
        avatar: 'https://randomuser.me/api/portraits/men/80.jpg',
        name: 'Smith Does',
    },
    group:{
        id: 1,
        name: 'Laravel Developers',
    },
    body: `
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus neque alias necessitatibus soluta iste aut animi corporis? Voluptate totam aperiam, praesentium necessitatibus magnam officiis aliquid rem nobis fuga inventore consequatur.</p>

    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus neque alias necessitatibus soluta iste aut animi corporis? Voluptate totam aperiam, praesentium necessitatibus magnam officiis aliquid rem nobis fuga inventore consequatur.</p>`,
    created_at: '2023-10-01 12:00:00',
};
</script>

<template>
    <div class="overflow-auto">
        <PostItem :post="post1" />
        <PostItem :post="post2" />
    </div>
</template>

<style scoped>

</style>
