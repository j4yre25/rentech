<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Multiselect from '@vueform/multiselect';
import { toRaw, unref } from 'vue';



const categories = defineProps({
    categories: {
        type: Array,
        default: () => ({ categories: [] }),
    },
});

console.log("CATEGORIES (Reactive Proxy):", categories);

const rawCategories = toRaw(categories).categories; // Access the array inside the object
console.log("RAW CATEGORIES ARRAY:", rawCategories);

const categoryNames = Array.isArray(rawCategories)
    ? rawCategories.map(category => category.name)
    : [];
console.log("CATEGORY NAMES:", categoryNames);

const categoryOptions = Array.isArray(rawCategories)
    ? rawCategories.map(category => ({ label: category.name, value: category.id }))
    : [];
console.log("CATEGORY OPTIONS:", categoryOptions);

const form = useForm({
    name: '',
    price: '',
    category_id: '',
    stock_quantity: '',
    color: '',
    description: '',
    images: '',
});




const saveProduct = () => {
    console.log('saveProduct called');

    form.post(route('products.store'), {
        onSuccess: () => {
            console.log('Product created successfully.');
            form.reset();
        },
        onError: (errors) => {
            console.log('Validation errors:', errors);
        },
    });
};
</script>

<template>
    <AppLayout title="Add Product">
        <div class="add-product-page">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="md:col-span-2">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h2 class="text-lg font-semibold mb-4">Information</h2>
                        <div class="form-group">
                            <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                            <input type="text" id="name" v-model="form.name" class="input-field" required />
                        </div>

                        <div class="form-group">
                            <label for="description" class="block text-sm font-medium text-gray-700">Product Description</label>
                            <textarea id="description" v-model="form.description" class="input-field"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="images" class="block text-sm font-medium text-gray-700">Images</label>
                            <input type="file" id="images"  v-on:change
                            ="form.images" class="input-field" multiple />
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow mt-6">
                        <h2 class="text-lg font-semibold mb-4">Price</h2>
                        <div class="form-group">
                            <label for="price" class="block text-sm font-medium text-gray-700">Product Price</label>
                            <input type="number" id="price" v-model="form.price" class="input-field" required />
                        </div>

                        <div class="form-group">
                            <label for="discount_price" class="block text-sm font-medium text-gray-700">Discount Price</label>
                            <input type="number" id="discount_price" v-model="form.discount_price" class="input-field" />
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow mt-6">
                        <h2 class="text-lg font-semibold mb-4">Different Options</h2>
                        <div class="form-group">
                            <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                            <input type="text" id="color" v-model="form.color" class="input-field" />
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h2 class="text-lg font-semibold mb-4">Categories</h2>
                        <Multiselect 
                            v-model="form.category_id" 
                            :options="categoryOptions" 
                            label="label" 
                            track-by="value" 
                            placeholder="Select category"
                            class="input-field" 
                        />
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow mt-6">
                        <h2 class="text-lg font-semibold mb-4">Tags</h2>
                        <input type="text" v-model="form.tags" placeholder="Enter tag name" class="input-field" />
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" class="btn btn-cancel mr-4">Cancel</button>
                <button type="submit" class="btn btn-save">Save</button>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.add-product-page {
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
</style>

<style>
@import '@vueform/multiselect/themes/default.css';
</style>