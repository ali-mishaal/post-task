<script setup>
import { onMounted, ref } from 'vue';

const handleImageUpload = (e) => {
    const file = e.target.files[0];
    form.image = file;
    form.imagePreview = URL.createObjectURL(file);
};

</script>

<template>
    <div>
        <label for="image">Image</label>
        <input id="image" type="file" @change="handleImageUpload">
    </div>

    <div v-if="form.imagePreview">
        <img :src="form.imagePreview" alt="Image Preview" style="max-width: 200px;">
    </div>
</template>
