<script setup>
import {computed, ref, toRef, watch} from "vue";

import EditPost from "@/Components/EditPost.vue";
import {router, useForm, usePage} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";

const showModal = ref(false);
const props = defineProps({
    post: {
        type: Object,
        required: true
    }
});
const post = props.post;

const commentsRef = toRef(props.post, 'comments');


const selectedComments = ref([]);
const deleteForm = useForm({
    ids: []
})

watch(
    () => selectedComments.value,
    (newValue) => {
        deleteForm.ids = newValue
    },
)

const { auth } = usePage().props;
const user = ref(auth.user);

const form = useForm({
    comment: '',
    post_id: post.id
});


const submitComment = () => {
    form.post(route('comments.store'), {
        onSuccess: (response) => {
            commentsRef.value.push({
                'id' : response.props.flash.data.id,
                'comment': form.comment,
                'user': {
                    'name': user.value.name
                }
            })

            form.comment = ''
        }
    });
};

const deleteSelectedComments = () => {
    if (confirm('Are you sure you want to delete this post?')) {
        deleteForm.post(route('comments.bulk.destroy'), {
            onSuccess: (response) => {
                commentsRef.value = commentsRef.value.filter(
                    (comment) => !selectedComments.value.includes(comment.id)
                );
            }
        });
    }
};


</script>

<template>
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4" @click="showModal = true">comments
    </button>
    <div class="modal" v-if="showModal">
        <div class="modal-content">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    post
                </h3>
                <button @click="showModal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span  class="sr-only">Close modal</span>
                </button>
            </div>

            <div class="w-full">
                <img width="350" class="rounded-t-lg" :src="post?.image_url" alt=""/>

                <div class="p-5">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ post.title }}
                    </h5>

                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        {{ post.body }}
                    </p>
                </div>

                <hr>
                <h4>comments</h4>
                <div>
                    <button  class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-4" @click="deleteSelectedComments">Delete Selected Comments</button>

                    <div v-for="comment in commentsRef" :key="comment.id"
                         class="flex w-full justify-between border rounded-md mt-2">

                        <div class="p-3">
                            <input v-if="user.id === post.user_id"
                                type="checkbox"
                                :id="'comment-' + comment.id"
                                :value="comment.id"
                                v-model="selectedComments"
                            >

                            <div class="flex gap-3 items-center">
                                <h3 class="font-bold">
                                    {{ comment?.user?.name }}
                                </h3>
                            </div>
                            <p class="text-gray-600 mt-2">
                                {{ comment.comment }}
                            </p>
                        </div>

                    </div>

                    <form @submit.prevent="submitComment">
                        <div>
                            <InputLabel for="comment" value="comment"/>
                            <TextInput
                                id="comment"
                                v-model="form.comment"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                                autocomplete="comment"
                            />
                            <InputError class="mt-2" :message="form.errors.comment"/>
                        </div>
                        <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 mt-2" type="submit">
                            Submit
                        </button>

                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mx-4" @click="showModal = false">Close Modal</button>
                    </form>

                </div>
            </div>
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
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
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
