<script setup>
import { usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';



const categories = usePage().props.categories;

function createCategory() {
  router.visit(route('categories.create'));
}

function editCategory(category) {
  router.visit(route('categories.edit', category.id));
}
</script>


<template>
    <AppLayout title="Categories">
        <div class="categories-page max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Categories</h1>
                <button @click="createCategory" class="btn btn-add">+ Add Category</button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="category in categories" :key="category.id" class="category-card">
                    <div class="relative">
                        <img :src="category.image" alt="Category Image" class="category-image" />
                        <button @click="editCategory(category)" class="btn btn-edit absolute top-2 right-2">Edit</button>
                    </div>
                    <div class="p-4">
                        <h2 class="text-lg font-bold">{{ category.name }}</h2>
                        <p class="text-sm text-gray-500">{{ category.products.length }} items</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.categories-page {
    font-family: 'Roboto', sans-serif;
    padding: 20px;
    background-color: #f9f9f9;
}

.btn-add {
    padding: 10px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s;
}

.btn-add:hover {
    background-color: #0056b3;
}

.category-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    background-color: white;
}

.category-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.btn-edit {
    padding: 5px 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
    transition: background-color 0.3s;
}

.btn-edit:hover {
    background-color: #0056b3;
}
</style>
