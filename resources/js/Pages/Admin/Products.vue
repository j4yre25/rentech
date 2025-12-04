<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Pagination from '@/Components/Pagination.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { router } from '@inertiajs/vue3';


defineProps({
    title: String,
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
            <div class="filters">
                <input type="text" placeholder="Search by name" v-model="filters.name" @input="fetchProducts" class="input-field" />
                <button class="btn btn-add" @click="navigateToCreateProduct">Add Product</button>
            </div>

            <table class="products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products.data" :key="product.id">
                        <td>{{ product.id }}</td>
                        <td>{{ product.name }}</td>
                        <td>{{ product.price }}</td>
                        <td>
                            <button class="btn btn-edit" @click="editProduct(product.id)">Edit</button>
                            <button class="btn btn-delete" @click="deleteProduct(product.id)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <pagination :links="products.links" @navigate="fetchProducts" />
        </div>
    </AppLayout>
</template>

<style scoped>
.products-page {
    display: flex;
    flex-direction: column;
    font-family: 'Roboto', sans-serif;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.filters {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    align-items: center;
}

.input-field {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 200px;
    font-size: 14px;
}

.btn-add {
    padding: 10px 15px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s;
}

.btn-add:hover {
    background-color: #218838;
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

.btn {
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-edit {
    background-color: #007bff;
    color: white;
}

.btn-edit:hover {
    background-color: #0056b3;
}

.btn-delete {
    background-color: #dc3545;
    color: white;
}

.btn-delete:hover {
    background-color: #c82333;
}
</style>
