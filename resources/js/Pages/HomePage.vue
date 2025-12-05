<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import LandingAppLayout from '@/Components/layout/LandingAppLayout.vue';
import NavBar from '@/Components/layout/NavBar.vue';
import HeroSection from '@/Components/home/HeroSection.vue';
import FeaturesSection from '@/Components/home/FeaturesSection.vue';

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
    <Head title="Home - Rent Premium Gadgets" />
    <NavBar />
    <HeroSection @submit-search="handleSearch" />
    <FeaturesSection/>
    <ProductsSection/>
    <Footer />
</template>

