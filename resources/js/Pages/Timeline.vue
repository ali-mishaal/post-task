<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreatePost from "@/Components/CreatePost.vue";
import Post from "@/Components/post.vue";
import {usePage} from "@inertiajs/vue3";

const {posts} = usePage().props;

const updatePosts = (postId) => {
    const index = posts.findIndex((post) => post.id === postId);
    if (index !== -1) {
        posts.splice(index, 1);
    }
}
</script>

<template>
    <AppLayout title="Timeline">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('timeline') }}
            </h2>
        </template>

        <CreatePost/>

        <div v-for="post in posts" :key="post.id"
             class=" mt-6 px-6 py-4 w-1/2 mx-auto bg-white shadow-md overflow-hidden sm:rounded-lg">
            <Post @update-posts="updatePosts" :post="post"/>
        </div>
    </AppLayout>
</template>
