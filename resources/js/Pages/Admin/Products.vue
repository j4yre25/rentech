<script setup>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';
import Pagination from '@/Components/Pagination.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { router, } from '@inertiajs/vue3';
import { debounce } from 'lodash';

const props = defineProps({
    title: String,
    category: String,
    products: Object,
    filters: Object,
});

console.log(props);


const search = ref(props.filters?.name || '');
const selectedProducts = ref([]);

watch(search, debounce((value) => {
    router.get(route('products.index'), { name: value }, {
        preserveState: true,
        replace: true,
    });
}, 300));

const toggleAll = (e) => {
    if (e.target.checked) {
        selectedProducts.value = props.products.data.map(p => p.id);
    } else {
        selectedProducts.value = [];
    }
};

const navigateToCreateProduct = () => {
    router.visit(route('products.create'));
};

const editProduct = (id) => {
    console.log(`Navigating to edit product with ID: ${id}`);
    router.visit(route('products.edit', { id }));
};

const deleteProduct = (id) => {
    console.log(`Delete product with ID: ${id}`);
};



// Search Debounce
watch(search, debounce((value) => {
    router.get(route('products.index'), { name: value }, {
        preserveState: true,
        replace: true,
    });
}, 300));


// Placeholder actions
const exportProducts = () => console.log('Exporting...');
const deleteSelected = () => console.log('Deleting', selectedProducts.value);
</script>

<template>
    <AppLayout title="Products">
        <div class="min-h-screen bg-gray-50 p-8 font-sans">

            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Products</h1>

                <div class="flex items-center gap-3">
                    <button @click="exportProducts"
                        class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm transition-colors">
                        Export
                    </button>

                    <button @click="navigateToCreateProduct"
                        class="px-4 py-2 bg-yellow-400 border border-transparent rounded-md text-sm font-medium text-gray-900 hover:bg-yellow-500 shadow-sm flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Add Product
                    </button>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">

                <div class="p-4 flex flex-col sm:flex-row items-center justify-between border-b border-gray-100 gap-4">

                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <div class="relative">
                            <select
                                class="appearance-none pl-3 pr-8 py-2 border border-gray-300 rounded-md text-sm text-gray-600 focus:ring-yellow-400 focus:border-yellow-400 bg-white shadow-sm cursor-pointer">
                                <option value="">Filter</option>
                                <option value="instock">In Stock</option>
                                <option value="outofstock">Out of Stock</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <div class="relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input v-model="search" type="text" placeholder="Search..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-yellow-400 focus:border-yellow-400 w-full shadow-sm placeholder-gray-400" />
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                   
                        <button @click="deleteSelected"
                            class="p-2 text-gray-400 hover:text-red-600 border border-gray-200 rounded hover:bg-gray-50 transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="p-4 w-4">
                                    <input type="checkbox" @change="toggleAll"
                                        class="rounded border-gray-300 text-yellow-500 focus:ring-yellow-400 h-4 w-4 cursor-pointer">
                                </th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">
                                    Product</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Inventory</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Color
                                </th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Price
                                </th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Rating
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-for="product in products.data" :key="product.id"
                                class="hover:bg-gray-50 transition duration-150">
                                <td class="p-4">
                                    <input type="checkbox" :value="product.id" v-model="selectedProducts"
                                        class="rounded border-gray-300 text-yellow-500 focus:ring-yellow-400 h-4 w-4 cursor-pointer">
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="h-10 w-10 flex-shrink-0 bg-gray-100 rounded-md border border-gray-200 overflow-hidden">
                                            <img :src="product.image" :alt="product.name" class="h-full w-full object-cover">
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ product.name }}</div>
                                            <div class="text-xs text-gray-500">{{ product.category?.name ||
                                                'Accessories' }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-sm">
                                    <span v-if="product.stock_quantity > 0" class="text-gray-700">
                                        {{ product.stock_quantity }} in stock
                                    </span>
                                    <span v-else
                                        class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                        Out of Stock
                                    </span>
                                </td>

                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ product.color }}
                                </td>

                                <td class="px-4 py-3 text-sm text-gray-600 font-medium">
                                    ${{ product.price }}
                                </td>

                                <td class="px-4 py-3 text-sm text-gray-600">
                                    <div class="flex items-center gap-1">
                                        <span class="font-medium">{{ product.rating }}</span>
                                        <span class="text-gray-400 text-xs">({{ product.votes }} Votes)</span>
                                    </div>
                                </td>

                                <td class="px-4 py-3">
                                    <button v-if="product && product.id" @click="editProduct(product.id)"
                                        class="p-2 text-gray-400 hover:text-blue-600 border border-gray-200 rounded hover:bg-gray-50 transition-colors">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-4 border-t border-gray-200 flex items-center justify-between">
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <Pagination :links="products.links" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">
                                <span class="font-medium">{{ products.total }}</span> Results
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>