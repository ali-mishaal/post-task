<script setup>
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import {ref} from "vue";

const props = defineProps({
    post: {
        type: Object,
        required: true
    }
});

const post = props.post;

const showModal = ref(false);

const form = useForm({
    title: post?.title,
    body: post?.body,
    image: null,
    imagePreview: post?.media[0]?.original_url,
});

const updatePost = (postId) => {
    form.post(route('posts.update', { id: postId }), {
        onSuccess: (response) =>  {
            showModal.value = false;
            const indexOFUpdatedPost =  response.props.posts.findIndex((post) => post.id === postId)
            const updatedPost = response.props.posts[indexOFUpdatedPost];
            post.title = updatedPost.title;
            post.body = updatedPost.body;
            post.image_url = updatedPost.image_url;
        }
    });
};

const handleImageUpload = (e) => {
    const file = e.target.files[0];
    form.image = file;
    form.imagePreview = URL.createObjectURL(file);
};


</script>

<template>
    <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white" @click="showModal = true">edit</button>
    <div class="modal" v-if="showModal">
        <div class="modal-content">
            <form @submit.prevent="updatePost(post.id)" enctype="multipart/form-data">

                <div>
                    <InputLabel for="title" value="title"/>
                    <TextInput
                        id="title"
                        v-model="form.title"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        autofocus
                        autocomplete="title"
                    />
                    <InputError class="mt-2" :message="form.errors.title"/>
                </div>

                <div>
                    <InputLabel for="body" value="body"/>
                    <TextArea
                        id="title"
                        v-model="form.body"
                        type="text"
                        rows="5"
                        class="mt-1 block w-full"
                        required
                        autofocus
                        autocomplete="body"
                    />
                    <InputError class="mt-2" :message="form.errors.body"/>
                </div>

                <div>
                    <InputLabel for="image" value="image"/>
                    <input id="image" type="file" @change="handleImageUpload">

                    <InputError class="mt-2" :message="form.errors.image"/>
                </div>

                <div v-if="form.imagePreview">
                    <img :src="form.imagePreview" alt="Image Preview" style="max-width: 200px;">
                </div>

                <div class="mt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 ">
                        update Post
                    </button>

                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-4" @click="showModal = false">Close Modal</button>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
.modal { /* Hide modal by default */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);  /* Semi-transparent background */
}

/* Style the modal content */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

/* Style the close button */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>
