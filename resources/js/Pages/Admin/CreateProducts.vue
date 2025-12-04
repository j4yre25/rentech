<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const form = useForm({
    name: '',
    price: '',
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
    <AppLayout title="Create Product">
        <div class="create-product-page">
            <form @submit.prevent="saveProduct">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" id="name" v-model="form.name" class="input-field" required />
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" id="price" v-model="form.price" class="input-field" required />
                </div>

                <button type="submit" class="btn btn-save">Save</button>
            </form>
        </div>
    </AppLayout>
</template>

<style scoped>
.create-product-page {
    display: flex;
    flex-direction: column;
    font-family: 'Roboto', sans-serif;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.input-field {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
    font-size: 14px;
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
</style>