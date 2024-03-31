<script setup>

import {router, usePage} from '@inertiajs/vue3'
import EditPost from "@/Components/EditPost.vue";
import {ref} from "vue";
import Comments from "@/Components/Comments.vue";
import {createToaster} from "@meforma/vue-toaster";

defineProps({
    post: Object
});
const {posts} = usePage().props;
const isOpen = ref(false)
const toaster = createToaster({});

const {auth} = usePage().props;
const user = ref(auth.user);
const emits = defineEmits(['update-posts'])

const deletePost = (postId) => {
    if (confirm('Are you sure you want to delete this post?')) {
        router.delete(route('posts.destroy', {id: postId}), {
            preserveScroll: true,
            onSuccess: (response) => {
                emits('update-posts', postId)
                toaster.show(response.props.flash.success);
            }
        });
    }
};

</script>

<template>
    <div class="w-full relative">
        <div v-if="post.user_id === user.id" class="absolute right-0 justify-end px-4 pt-4">
            <button @click="isOpen = !isOpen "
                    class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                     viewBox="0 0 16 3">
                    <path
                        d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                </svg>
            </button>


            <div v-if="isOpen"
                 class="absolute right-0 z-10  text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                <ul class="py-2" aria-labelledby="dropdownButton">
                    <li>
                        <EditPost :post="post"/>
                    </li>
                    <li>
                        <a @click="deletePost(post.id)"
                           class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"> {{ $t('delete') }}</a>
                    </li>
                </ul>
            </div>
        </div>



        <div v-if="post.image_url" class="relative " style="height: 450px; top: 50px">
            <img class="rounded-t-lg" :src="post?.image_url" alt=""
                 style="width: 100%; height: 100%; object-fit: contain;">
        </div>

        <div class="p-5">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ post.title }}
            </h5>

            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                {{ post.body }}
            </p>
        </div>

        <Comments :post="post"/>
    </div>
</template>
