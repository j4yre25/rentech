<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { Link, Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import {  router } from '@inertiajs/vue3';
import LandingAppLayout from '@/Components/layout/LandingAppLayout.vue';
import NavBar from '@/Components/layout/NavBar.vue';
import HomePage from '@/Pages/Customer/HomePage.vue';


const page = usePage()

const userRole = page.props.auth?.role;
console.log('User Role:', userRole);

defineProps({
    products: {
        type: Array,
        default: () => []
    }
});

const searchForm = ref({
    category: '',
    duration: '',
    start_date: '',
    end_date: ''
});

const handleSearch = () => {
    router.get(route('products.index'), searchForm.value);
};



</script>

<template>
    <div v-if="userRole == 'rentor'">
        <AppLayout title="Dashboard">
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Dashboard
                </h2>
            </template>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <Welcome />
                    </div>
                </div>
            </div>
        </AppLayout>
    </div>


    <div v-if="userRole == 'rentee'">
        <HomePage />
        
        

    </div>
</template>
