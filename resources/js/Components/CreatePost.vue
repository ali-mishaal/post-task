<script setup>
import {Head, useForm, usePage} from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from "@/Components/TextArea.vue";
import {ref} from "vue";
import {createToaster} from "@meforma/vue-toaster";


defineProps({
    canResetPassword: Boolean,
    status: String,
});

const successMessage = ref('');
const { posts } = usePage().props;
const toaster = createToaster({});

const form = useForm({
    title: '',
    body: '',
    image: null,
    imagePreview: null,
});

const handleImageUpload = (e) => {
    const file = e.target.files[0];
    form.image = file;
    form.imagePreview = URL.createObjectURL(file);
};

const submitPost = () => {
    form.post(route('posts.store'), {
        preserveScroll: true,
        onSuccess: (response) =>  {
            posts.unshift(response.props.posts[0])
            successMessage.value = response.success;
            form.title = '';
            form.body = '';
            form.image = null;
            form.imagePreview = null;
            toaster.show(response.props.flash.success);
        }
    });
};


</script>

<template>
    <Head title="create post"/>

    <div class=" mt-6 px-6 py-4 w-1/2 mx-auto bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div v-if="successMessage" class="success-message">
            {{ successMessage }}
        </div>

        <form @submit.prevent="submitPost" enctype="multipart/form-data">

            <div>
                <InputLabel for="title" :value="$t('title')"/>
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
                <InputLabel for="body" :value="$t('body')"/>
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
                <InputLabel for="image" :value="$t('image')"/>
                <input id="image" type="file" @change="handleImageUpload">

                <InputError class="mt-2" :message="form.errors.image"/>
            </div>

            <div v-if="form.imagePreview">
                <img :src="form.imagePreview" alt="Image Preview" style="max-width: 200px;">
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 ">
                    {{ $t('createPost') }}
                </button>
            </div>
        </form>
    </div>


</template>
