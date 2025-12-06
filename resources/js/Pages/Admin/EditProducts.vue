<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';

const props = defineProps({
    categories: {
        type: Array,
        default: () => [
            { id: 1, name: 'VR Headsets' },
            { id: 2, name: 'Laptops' },
            { id: 3, name: 'Phones' },
            { id: 4, name: 'DSLR Cameras' },
            { id: 5, name: 'Headphones' },
        ], // Default mock data if empty
    },
    product: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.product.name || '',
    description: props.product.description || '',
    category_id: props.product.category_id || '',
    price: props.product.price || '',
    discount_price: props.product.discount_price || '',
    is_taxable: props.product.is_taxable || false,
    has_options: props.product.has_options || true, // Default true to show the section per image
    images: props.product.images || [],
    selected_categories: props.product.selected_categories || [],
    tags: props.product.tags || [],
    options: props.product.options || [
        { name: 'Color', values: ['White', 'Black'] }
    ],
    new_tag: '',
    stock_quantity: props.product.stock_quantity || '',
    color: props.product.color || '#000000',
});

// Helper for Tag Input
const addTag = () => {
    if (form.new_tag.trim()) {
        form.tags.push(form.new_tag);
        form.new_tag = '';
    }
};

const removeTag = (index) => {
    form.tags.splice(index, 1);
};

const handleFileUpload = (event) => {
    const files = event.target.files;
    if (files.length > 0) {
        // Use the first file's name as a string
        form.images = files[0].name;

        // Alternatively, convert the file to a base64 string if needed
        // const reader = new FileReader();
        // reader.onload = (e) => {
        //     form.images = e.target.result; // Base64 string
        // };
        // reader.readAsDataURL(files[0]);
    } else {
        form.images = ''; // Reset to an empty string if no files are selected
    }
};

const updateProduct = () => {
    console.log(form); // Debugging: Check the form data
    form.put(route('products.update', props.product.id), {
        onSuccess: () => {
            form.reset(); // Reset the form on success
        },
        onError: (errors) => {
            console.error(errors); // Log validation errors
        },
    });
};
</script>

<template>
    <AppLayout title="Edit Product">
        <div class="min-h-screen bg-gray-50 p-8 font-sans">
            
            <div class="max-w-7xl mx-auto mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <Link :href="route('products.index')" class="flex items-center text-sm text-gray-500 hover:text-gray-700 mb-1">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </Link>
                    <h1 class="text-2xl font-bold text-gray-900">Edit Product</h1>
                </div>
                <div class="flex gap-3">
                    <button class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm">
                        Cancel
                    </button>
                    <button @click="updateProduct" class="px-4 py-2 bg-yellow-400 border border-transparent rounded-md text-sm font-medium text-gray-900 hover:bg-yellow-500 shadow-sm">
                        Save
                    </button>
                </div>
            </div>

            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <h2 class="text-base font-bold text-gray-900 mb-4">Information</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Product Name</label>
                                <input v-model="form.name" type="text" placeholder="Summer T-Shirt" class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-sm placeholder-gray-400">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Product Description</label>
                                <textarea v-model="form.description" rows="4" placeholder="Product description" class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-sm placeholder-gray-400 resize-none"></textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Stock Quantity</label>
                                <input v-model="form.stock_quantity" type="number" placeholder="Enter stock quantity" class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-sm placeholder-gray-400">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <h2 class="text-base font-bold text-gray-900 mb-4">Images</h2>
                        
                        <div class="border-2 border-dashed border-gray-200 rounded-lg p-8 flex flex-col items-center justify-center text-center cursor-pointer hover:bg-gray-50 transition-colors">
                            <input type="file" class="hidden" id="file-upload" multiple @change="handleFileUpload">
                            <label for="file-upload" class="cursor-pointer">
                                <span class="text-blue-600 font-semibold text-sm">Add File</span>
                                <span class="block text-gray-400 text-xs mt-1">Or drag and drop files</span>
                            </label>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <h2 class="text-base font-bold text-gray-900 mb-4">Price</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Product Price</label>
                                <input v-model="form.price" type="number" placeholder="Enter price" class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-sm placeholder-gray-400">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Discount Price</label>
                                <input v-model="form.discount_price" type="number" placeholder="Price at Discount" class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-sm placeholder-gray-400">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <button 
                                type="button" 
                                @click="form.is_taxable = !form.is_taxable"
                                :class="form.is_taxable ? 'bg-yellow-400' : 'bg-gray-200'"
                                class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
                            >
                                <span 
                                    :class="form.is_taxable ? 'translate-x-4' : 'translate-x-0'"
                                    class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                ></span>
                            </button>
                            <span class="ml-3 text-sm text-gray-600">Add tax for this product</span>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <h2 class="text-base font-bold text-gray-900 mb-4">Color</h2>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Select Color</label>
                            <input 
                                v-model="form.color" 
                                type="color" 
                                class="w-16 h-10 border-gray-300 rounded-md shadow-sm focus:ring-yellow-400 focus:border-yellow-400"
                            >
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <h2 class="text-base font-bold text-gray-900 mb-4">Categories</h2>
                        
                        <div class="space-y-3 mb-4">
                            <div v-for="category in props.categories" :key="category.id" class="flex items-center">
                                <input 
                                    :id="`category-${category.id}`" 
                                    :value="category.id" 
                                    v-model="form.category_id" 
                                    type="radio" 
                                    class="h-4 w-4 text-yellow-400 focus:ring-yellow-400 border-gray-300 rounded"
                                >
                                <label :for="`category-${category.id}`" class="ml-3 text-sm text-gray-600 select-none">
                                    {{ category.name }}
                                </label>
                            </div>
                        </div>
                        
                        <a href="#" class="text-blue-600 text-sm font-medium hover:underline">Create New</a>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-base font-bold text-gray-900">Tags</h2>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Add Tags</label>
                            <input 
                                v-model="form.new_tag" 
                                @keydown.enter.prevent="addTag"
                                type="text" 
                                placeholder="Enter tag name" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-400 focus:ring-yellow-400 text-sm placeholder-gray-400 mb-3"
                            >
                            
                            <div class="flex flex-wrap gap-2">
                                <span 
                                    v-for="(tag, index) in form.tags" 
                                    :key="index"
                                    class="inline-flex items-center px-2.5 py-1 rounded bg-gray-100 text-gray-700 text-xs font-medium border border-gray-200"
                                >
                                    {{ tag }}
                                    <button 
                                        type="button" 
                                        @click="removeTag(index)"
                                        class="ml-1.5 text-gray-400 hover:text-gray-600 focus:outline-none"
                                    >
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto mt-6 flex justify-end gap-3 pb-8">
                 <button class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm">
                    Cancel
                </button>
                <button @click="updateProduct" class="px-4 py-2 bg-yellow-400 border border-transparent rounded-md text-sm font-medium text-gray-900 hover:bg-yellow-500 shadow-sm">
                    Save
                </button>
            </div>

        </div>
    </AppLayout>
</template>