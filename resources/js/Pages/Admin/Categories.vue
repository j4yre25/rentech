<script setup>
import { usePage, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

// Access props directly
const props = defineProps({
    categories: Array
});

// Fallback if categories aren't passed via props (for preview safety)
const categoriesList = props.categories || usePage().props.categories || [];

function createCategory() {
    router.visit(route('categories.create'));
}

function editCategory(category) {
    router.visit(route('categories.edit', category.id));
}
</script>

<template>
    <AppLayout title="Categories">
        <div class="min-h-screen bg-gray-50 p-8 font-sans">
            
            <div class="max-w-7xl mx-auto mb-8 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900">Categories</h1>
                
                <button 
                    @click="createCategory" 
                    class="flex items-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-5 py-2.5 rounded-md text-sm font-medium transition-colors shadow-sm"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Category
                </button>
            </div>

            <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <div 
                    v-for="category in categoriesList" 
                    :key="category.id" 
                    class="group bg-white rounded-lg border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300"
                >
                    <div class="relative h-64 w-full bg-gray-100 overflow-hidden">
                        <img 
                            :src="category.image" 
                            :alt="category.name" 
                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500" 
                        />
                        
                        <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <button 
                                @click="editCategory(category)" 
                                class="bg-white text-blue-600 hover:text-blue-700 px-4 py-2 rounded shadow-lg font-medium text-sm flex items-center gap-2 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit
                            </button>
                        </div>
                    </div>

                    <div class="p-5">
                        <h2 class="text-lg font-bold text-gray-900 mb-1">{{ category.name }}</h2>
                        <p class="text-sm text-gray-500">{{ category.products_count || category.products?.length || 0 }} items</p>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>