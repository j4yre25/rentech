<script setup>
import { useForm } from '@inertiajs/vue3';
import { usePage, } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';

const { category, products } = usePage().props;

// Filter unique products
const uniqueProducts = category.products.map(product => ({
    id: product.id,
    name: product.name,
    image: product.image,
}));

const form = useForm({
    name: category.name || '',
    image: null,
    visible: category.visible || true,
    products: (category.products || []).map(product => product.id),
});

const showModal = ref(false);
const availableProducts = products.filter(product => !form.products.includes(product.id));
const selectedProducts = ref([]);

function submit() {
    form.put(route('categories.update', category.id), {
        onSuccess: () => {
            console.log('Category updated successfully.');
        },
        onError: (errors) => {
            console.error('Validation errors:', errors);
        },
    });
}

function addProduct() {
    showModal.value = true;
}

function addSelectedProducts(selected) {
    form.products.push(...selected.map(product => product.id));
    showModal.value = false;
    selectedProducts.value = [];
}
</script>

<template>
    <AppLayout title="Edit Category">
        <div class="edit-category-page max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="md:col-span-2">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h2 class="text-lg font-semibold mb-4">Products</h2>
                        <div class="space-y-4">
                            <div v-for="product in uniqueProducts" :key="product.id" class="flex items-center gap-4">
                                <img :src="product.image" alt="Product Image" class="product-image" />
                                <div class="flex-1">
                                    <p class="font-medium">{{ product.name }}</p>
                                </div>
                                <button @click="editProduct(product)" class="btn btn-edit">Edit</button>
                                <button @click="deleteProduct(product)" class="btn btn-delete">Delete</button>
                            </div>
                        </div>
                        <button @click="addProduct" class="btn btn-add mt-4">+ Add Product</button>
                    </div>
                </div>

                <!-- Right Column -->
                <div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h2 class="text-lg font-semibold mb-4">Category Visibility</h2>
                        <div class="flex items-center gap-4">
                            <label class="switch">
                                <input type="checkbox" v-model="form.visible" />
                                <span class="slider"></span>
                            </label>
                            <span class="text-sm font-medium">Visible on site</span>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow mt-6">
                        <h2 class="text-lg font-semibold mb-4">Category Info</h2>
                        <div class="form-group">
                            <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                            <input type="text" id="name" v-model="form.name" class="input-field" required />
                        </div>

                        <div class="form-group mt-4">
                            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                            <input type="file" id="image" v-on:change="form.image" class="input-field" />
                        </div>
                    </div>


                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" class="btn btn-cancel mr-4">Cancel</button>
                <button type="button" @click="submit" class="btn btn-save">Save</button>
            </div>

            <!-- Modal for Adding Products -->
            <Modal v-model:show="showModal" title="Add Products to Category">
                <div class="p-6 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700">Select Products</h3>
                    <div class="space-y-2">
                        <div v-for="product in availableProducts" :key="product.id" class="flex items-center gap-2">
                            <input 
                                type="checkbox" 
                                :value="product.id" 
                                v-model="selectedProducts" 
                                class="form-checkbox h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring focus:ring-blue-200 focus:border-blue-500"
                            />
                            <label :for="product.id" class="text-sm text-gray-700">{{ product.name }}</label>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end p-6 bg-gray-100 rounded-b-lg">
                    <button @click="showModal = false" class="btn btn-cancel mr-4">Cancel</button>
                    <button @click="addSelectedProducts(selectedProducts)" class="btn btn-save">Add Products</button>
                </div>
            </Modal>
        </div>
    </AppLayout>
</template>

<style scoped>
.edit-category-page {
    font-family: 'Roboto', sans-serif;
    padding: 20px;
    background-color: #f9f9f9;
}

.input-field {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
    font-size: 14px;
    margin-top: 5px;
}

.btn-save {
    padding: 10px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s;
}

.btn-save:hover {
    background-color: #0056b3;
}

.btn-cancel {
    padding: 10px 15px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s;
}

.btn-cancel:hover {
    background-color: #c82333;
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

.btn-delete {
    padding: 5px 10px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
    transition: background-color 0.3s;
}

.btn-delete:hover {
    background-color: #c82333;
}

.product-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 4px;
}

.switch {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 20px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 20px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 14px;
    width: 14px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
}

input:checked+.slider {
    background-color: #007bff;
}

input:checked+.slider:before {
    transform: translateX(20px);
}
</style>
