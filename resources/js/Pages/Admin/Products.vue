<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Pagination from '@/Components/Pagination.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { router } from '@inertiajs/vue3';


defineProps({
    title: String,
    category: String,
});

const products = ref({ data: [], links: [] });
const filters = ref({ name: '' });


const fetchProducts = async () => {
    const response = await axios.get('/products', { params: filters.value });
    products.value = response.data;
};


const editProduct = (id) => {
    console.log(`Edit product with ID: ${id}`);
};

const deleteProduct = (id) => {
    console.log(`Delete product with ID: ${id}`);
};

const navigateToCreateProduct = () => {
   router.get(route('products.create'));
};

onMounted(fetchProducts);
</script>

<template>
    <AppLayout title="Products">
        <div class="products-page">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-4">
                    <select class="input-field">
                        <option value="">Filter</option>
                        <!-- Add filter options here -->
                    </select>
                    <input type="text" placeholder="Search..." class="input-field" v-model="filters.name" @input="fetchProducts" />
                </div>
                <div class="flex items-center gap-4">
                    <button class="btn btn-export">Export</button>
                    <button class="btn btn-add" @click="navigateToCreateProduct">+ Add Product</button>
                </div>
            </div>

            <table class="products-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" />
                        </th>
                        <th>Product</th>
                        <th>Inventory</th>
                        <th>Color</th>
                        <th>Price</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products.data" :key="product.id">
                        <td>
                            <input type="checkbox" />
                        </td>
                        <td>
                            <div class="flex items-center gap-4">
                                <img :src="product.image" alt="Product Image" class="product-image" />
                                <div>
                                    <p class="font-medium">{{ product.name }}</p>
                                    <p class="text-sm text-gray-500">{{ product.category?.name || 'Uncategorized' }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span v-if="product.stock_quantity > 0" class="text-green-600">{{ product.stock_quantity }} in stock</span>
                            <span v-else class="text-red-600">Out of Stock</span>
                        </td>
                        <td>{{ product.color }}</td>
                        <td>${{ product.price }}</td>
                        <td>{{ product.rating }} ({{ product.votes }} Votes)</td>
                        <td>
                            <div class="flex gap-2">
                                <button @click="editProduct(product.id)" class="btn btn-edit">Edit</button>
                                <button @click="deleteProduct(product.id)" class="btn btn-delete">Delete</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="pagination mt-6">
                <pagination :links="products.links" @navigate="fetchProducts" />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.products-page {
    font-family: 'Roboto', sans-serif;
    padding: 20px;
    background-color: #f9f9f9;
}

.input-field {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
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

.btn-export {
    padding: 10px 15px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s;
}

.btn-export:hover {
    background-color: #218838;
}

.btn-edit {
    padding: 10px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s;
}

.btn-edit:hover {
    background-color: #0056b3;
}

.btn-delete {
    padding: 10px 15px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s;
}

.btn-delete:hover {
    background-color: #c82f3f;
}

.products-table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.products-table th {
    background-color: #007bff;
    color: white;
    text-align: left;
    padding: 12px;
    font-size: 14px;
}

.products-table td {
    padding: 12px;
    border: 1px solid #ddd;
    font-size: 14px;
}

.product-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 4px;
}

.pagination {
    display: flex;
    justify-content: center;
}
</style>
