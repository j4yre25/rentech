<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import LandingAppLayout from '@/Components/layout/LandingAppLayout.vue';
import NavBar from '@/Components/layout/NavBar.vue';

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
    <LandingAppLayout>
        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-yellow-400 via-yellow-300 to-yellow-500 py-20">
            <div class="container mx-auto px-4">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left: Headline -->
                    <div>
                        <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                            Experience technology like never before
                        </h1>
                        <p class="text-xl text-gray-800 mb-8">
                            Rent the latest gadgets without the commitment. From cameras to laptops, get what you need, when you need it.
                        </p>
                        <Link 
                            :href="route('products.index')" 
                            class="inline-block bg-gray-900 text-white px-8 py-4 rounded-lg font-semibold hover:bg-gray-800 transition shadow-lg"
                        >
                            Browse Gadgets →
                        </Link>
                    </div>

                    <!-- Right: Search Form -->
                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <h3 class="text-2xl font-bold mb-6 text-gray-900">Start your rental</h3>
                        <form @submit.prevent="handleSearch" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700">What do you need?</label>
                                <select 
                                    v-model="searchForm.category" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition"
                                >
                                    <option value="">Select gadget type</option>
                                    <option value="laptops">Laptops</option>
                                    <option value="cameras">Cameras</option>
                                    <option value="audio">Audio Equipment</option>
                                    <option value="gaming">Gaming Consoles</option>
                                    <option value="accessories">Accessories</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700">Rental period</label>
                                <select 
                                    v-model="searchForm.duration" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition"
                                >
                                    <option value="">Select duration</option>
                                    <option value="1">1 Day</option>
                                    <option value="3">3 Days</option>
                                    <option value="7">1 Week</option>
                                    <option value="30">1 Month</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2 text-gray-700">Start date</label>
                                    <input 
                                        v-model="searchForm.start_date" 
                                        type="date" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition"
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2 text-gray-700">End date</label>
                                    <input 
                                        v-model="searchForm.end_date" 
                                        type="date" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition"
                                    >
                                </div>
                            </div>

                            <button 
                                type="submit"
                                class="w-full bg-yellow-400 text-gray-900 px-6 py-4 rounded-lg font-semibold hover:bg-yellow-500 transition shadow-md"
                            >
                                Search Gadgets
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="grid md:grid-cols-3 gap-12">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-gray-900">Instant Booking</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Book your gadget in seconds and get it delivered to your doorstep
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-gray-900">Premium Quality</h3>
                        <p class="text-gray-600 leading-relaxed">
                            All gadgets are tested, sanitized and in perfect working condition
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-gray-900">Flexible Returns</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Easy returns with free pickup service at your convenience
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Popular Gadgets Section -->
        <section class="py-20 bg-gradient-to-br from-yellow-400 via-yellow-300 to-yellow-500">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-900">Popular Gadgets</h2>
                    <Link 
                        :href="route('products.index')" 
                        class="text-gray-900 font-semibold hover:underline flex items-center gap-2 transition"
                    >
                        View all <span>→</span>
                    </Link>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div 
                        v-for="product in products" 
                        :key="product.id" 
                        class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-1"
                    >
                        <div class="p-6">
                            <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl mb-6 flex items-center justify-center">
                                <span class="text-6xl">{{ product.emoji }}</span>
                            </div>
                            
                            <h3 class="font-bold text-xl mb-3 text-gray-900">{{ product.name }}</h3>
                            
                            <div class="flex items-center gap-1 mb-4">
                                <svg v-for="i in 5" :key="i" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm text-gray-600 ml-2">({{ product.reviews }} reviews)</span>
                            </div>
                            
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                    <p class="text-3xl font-bold text-gray-900">${{ product.daily_rate }}</p>
                                    <p class="text-sm text-gray-600">per day</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <Link
                                    :href="route('view')"
                                    class="flex-1 bg-gray-900 text-white px-6 py-3 rounded-xl font-semibold hover:bg-gray-800 transition shadow-md text-center"
                                >
                                    View details
                                </Link>
                                <button 
                                    class="flex-1 bg-gray-900 text-white px-6 py-3 rounded-xl font-semibold hover:bg-gray-800 transition shadow-md"
                                >
                                    Rent Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-4xl font-bold mb-6 text-gray-900">Ready to start renting?</h2>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                    Join thousands of satisfied customers who trust RenTech for their gadget needs
                </p>
                <a 
                    href="#" 
                    class="inline-block bg-yellow-400 text-gray-900 px-10 py-4 rounded-lg font-bold text-lg hover:bg-yellow-500 transition shadow-lg"
                >
                    Get Started Today
                </a>
            </div>
        </section>
    </LandingAppLayout>
</template>

