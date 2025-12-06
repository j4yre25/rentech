<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { Link, Head, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import LandingAppLayout from '@/Components/layout/LandingAppLayout.vue';
import NavBar from '@/Components/layout/NavBar.vue';
import VueApexCharts from 'vue3-apexcharts';

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

// --- Chart Configurations to match the image ---
const ordersChartOptions = ref({
    chart: { type: 'area', toolbar: { show: false }, fontFamily: 'inherit' },
    colors: ['#3b82f6', '#e5e7eb'], // Blue and Gray lines
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth', width: 3 },
    xaxis: {
        categories: ['4am', '5am', '6am', '7am', '8am', '9am', '10am', '11am', '12am', '1pm', '2pm', '3pm'],
        axisBorder: { show: false },
        axisTicks: { show: false },
        labels: { style: { colors: '#9ca3af' } }
    },
    yaxis: { labels: { style: { colors: '#9ca3af' } } },
    grid: { borderColor: '#f3f4f6', strokeDashArray: 4 },
    fill: { opacity: 0.1, type: 'solid' },
    legend: { position: 'top', horizontalAlign: 'right' }
});

const ordersChartSeries = ref([
    { name: 'May 22', data: [10, 5, 15, 10, 25, 35, 30, 35, 48, 42, 25, 25, 35] },
    { name: 'May 21', data: [25, 8, 5, 5, 15, 22, 22, 30, 10, 20, 35, 40, 45] }
]);

const salesChartOptions = ref({
    chart: { type: 'bar', toolbar: { show: false }, fontFamily: 'inherit' },
    colors: ['#10b981'], // Green
    plotOptions: {
        bar: { borderRadius: 4, columnWidth: '40%', distributed: false }
    },
    dataLabels: { enabled: false },
    xaxis: {
        categories: ['12', '13', '14', '15', '16', '17', '18'],
        axisBorder: { show: false },
        axisTicks: { show: false },
        labels: { style: { colors: '#9ca3af' } }
    },
    grid: { show: false },
    yaxis: { show: false }
});

const salesChartSeries = ref([{ name: 'Sales', data: [20, 30, 25, 45, 50, 40, 50] }]);

// --- Mock Data ---
const transactions = [
    { name: 'Jagarnath S.', date: '24.05.2023', amount: '₱124.97', status: 'Paid' },
    { name: 'Anand G.', date: '23.05.2023', amount: '₱55.42', status: 'Pending' },
    { name: 'Kartik S.', date: '23.05.2023', amount: '₱89.90', status: 'Paid' },
    { name: 'Rakesh S.', date: '22.05.2023', amount: '₱144.94', status: 'Pending' },
    { name: 'Anup S.', date: '22.05.2023', amount: '₱70.52', status: 'Paid' },
];

const products = [
    { name: 'Apple MacBook Air', price: '₱350', rented: 204, img: 'https://via.placeholder.com/40' },
    { name: 'Samsung Galaxy Tab S9', price: '₱200', rented: 155, img: 'https://via.placeholder.com/40' },
    { name: 'Canon EOS Mark II', price: '₱300', rented: 120, img: 'https://via.placeholder.com/40' },
    { name: 'Lenovo ThinkPad X1', price: '₱320', rented: 204, img: 'https://via.placeholder.com/40' },
    { name: 'ASUS ROG Strix G16', price: '₱450', rented: 155, img: 'https://via.placeholder.com/40' },
];
</script>

<template>
    <div v-if="userRole == 'rentor'" class="min-h-screen bg-gray-50 font-sans">
        <AppLayout title="Dashboard">
            <template #header>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    Dashboard
                </h2>
            </template>

            <div class="py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-3xl font-bold text-gray-900">₱10,540</p>
                                    <p class="text-sm font-medium text-gray-500 mt-1">Total Revenue</p>
                                    <p
                                        class="text-xs font-semibold text-green-500 mt-2 bg-green-50 inline-block px-2 py-1 rounded">
                                        +22.45% <span class="text-gray-400 font-normal">vs last month</span>
                                    </p>
                                </div>
                                <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-3xl font-bold text-gray-900">1,056</p>
                                    <p class="text-sm font-medium text-gray-500 mt-1">Orders</p>
                                    <p
                                        class="text-xs font-semibold text-green-500 mt-2 bg-green-50 inline-block px-2 py-1 rounded">
                                        +15.34%
                                    </p>
                                </div>
                                <div class="p-3 bg-indigo-50 rounded-full text-indigo-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-3xl font-bold text-gray-900">1,650</p>
                                    <p class="text-sm font-medium text-gray-500 mt-1">New Users</p>
                                    <p
                                        class="text-xs font-semibold text-green-500 mt-2 bg-green-50 inline-block px-2 py-1 rounded">
                                        +15.34%
                                    </p>
                                </div>
                                <div class="flex items-end space-x-1 h-10">
                                    <div class="w-1 bg-green-200 h-4 rounded-t"></div>
                                    <div class="w-1 bg-green-300 h-6 rounded-t"></div>
                                    <div class="w-1 bg-green-500 h-8 rounded-t"></div>
                                    <div class="w-1 bg-green-400 h-5 rounded-t"></div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-3xl font-bold text-gray-900">9,653</p>
                                    <p class="text-sm font-medium text-gray-500 mt-1">Existing Users</p>
                                    <p
                                        class="text-xs font-semibold text-green-500 mt-2 bg-green-50 inline-block px-2 py-1 rounded">
                                        +22.45%
                                    </p>
                                </div>
                                <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

                        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">Orders Over Time</h3>
                                    <div class="flex items-center space-x-4 mt-2">
                                        <div class="flex items-center">
                                            <span class="text-2xl font-bold text-gray-900">645</span>
                                            <span class="text-xs text-gray-500 ml-2">Orders on May 22</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="text-2xl font-bold text-gray-900 text-opacity-50">472</span>
                                            <span class="text-xs text-gray-400 ml-2">Orders on May 21</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative">
                                    <button class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
                                        Last 12 Hours <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="h-72">
                                <VueApexCharts type="area" height="100%" :options="ordersChartOptions"
                                    :series="ordersChartSeries" />
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800 mb-2">Last 7 Days Sales</h3>
                                <p class="text-sm text-gray-500 mb-6">1,259 Items Sold</p>

                                <div class="mb-6">
                                    <p class="text-3xl font-bold text-gray-900">₱12,546</p>
                                    <p class="text-sm text-gray-500">Revenue</p>
                                </div>
                            </div>

                            <div class="h-48 relative">
                                <div
                                    class="absolute top-0 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-3 py-1 rounded shadow-lg z-10">
                                    ₱2,525
                                    <div
                                        class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-800 rotate-45">
                                    </div>
                                </div>
                                <VueApexCharts type="bar" height="100%" :options="salesChartOptions"
                                    :series="salesChartSeries" />
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-6">Recent Transactions</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="text-left border-b border-gray-200">
                                            <th
                                                class="pb-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                                Name</th>
                                            <th
                                                class="pb-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                                Date</th>
                                            <th
                                                class="pb-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                                Amount
                                            </th>
                                            <th
                                                class="pb-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                                Status
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <tr v-for="(item, index) in transactions" :key="index"
                                            class="group hover:bg-gray-50 transition-colors">
                                            <td class="py-4 text-sm font-medium text-gray-800">{{ item.name }}</td>
                                            <td class="py-4 text-sm text-gray-500">{{ item.date }}</td>
                                            <td class="py-4 text-sm font-medium text-gray-800">{{ item.amount }}</td>
                                            <td class="py-4">
                                                <span :class="[
                                                    'px-2.5 py-1 text-xs font-semibold rounded-md',
                                                    item.status === 'Paid' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'
                                                ]">
                                                    {{ item.status }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-lg font-bold text-gray-800">Top Products by Units Rented</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="text-left border-b border-gray-200">
                                            <th
                                                class="pb-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                                Name</th>
                                            <th
                                                class="pb-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                                Price</th>
                                            <th
                                                class="pb-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                                Units
                                                Rented</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <tr v-for="(item, index) in products" :key="index"
                                            class="hover:bg-gray-50 transition-colors">
                                            <td class="py-4">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0 bg-gray-200 rounded-lg mr-3">
                                                        <img :src="item.img" alt=""
                                                            class="h-10 w-10 rounded-lg object-cover">
                                                    </div>
                                                    <span class="text-sm font-medium text-gray-800">{{ item.name
                                                    }}</span>
                                                </div>
                                            </td>
                                            <td class="py-4 text-sm font-medium text-gray-800">{{ item.price }}</td>
                                            <td class="py-4 text-sm text-gray-500">{{ item.rented }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </AppLayout>
    </div>

    <div v-if="userRole == 'rentee'">
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
                                Rent the latest gadgets without the commitment. From cameras to laptops, get what you
                                need,
                                when you need it.
                            </p>
                            <Link :href="route('products.index')"
                                class="inline-block bg-gray-900 text-white px-8 py-4 rounded-lg font-semibold hover:bg-gray-800 transition shadow-lg">
                            Browse Gadgets →
                            </Link>
                        </div>

                        <!-- Right: Search Form -->
                        <div class="bg-white rounded-2xl shadow-2xl p-8">
                            <h3 class="text-2xl font-bold mb-6 text-gray-900">Start your rental</h3>
                            <form @submit.prevent="handleSearch" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2 text-gray-700">What do you
                                        need?</label>
                                    <select v-model="searchForm.category"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition">
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
                                    <select v-model="searchForm.duration"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition">
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
                                        <input v-model="searchForm.start_date" type="date"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-2 text-gray-700">End date</label>
                                        <input v-model="searchForm.end_date" type="date"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition">
                                    </div>
                                </div>

                                <button type="submit"
                                    class="w-full bg-yellow-400 text-gray-900 px-6 py-4 rounded-lg font-semibold hover:bg-yellow-500 transition shadow-md">
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
                            <div
                                class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-3 text-gray-900">Instant Booking</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Book your gadget in seconds and get it delivered to your doorstep
                            </p>
                        </div>

                        <div class="text-center">
                            <div
                                class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold mb-3 text-gray-900">Premium Quality</h3>
                            <p class="text-gray-600 leading-relaxed">
                                All gadgets are tested, sanitized and in perfect working condition
                            </p>
                        </div>

                        <div class="text-center">
                            <div
                                class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
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
                        <Link :href="route('dashboard')"
                            class="text-gray-900 font-semibold hover:underline flex items-center gap-2 transition">
                        View all <span>→</span>
                        </Link>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div v-for="product in products" :key="product.id"
                            class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                            <div class="p-6">
                                <div
                                    class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl mb-6 flex items-center justify-center">
                                    <span class="text-6xl">{{ product.emoji }}</span>
                                </div>

                                <h3 class="font-bold text-xl mb-3 text-gray-900">{{ product.name }}</h3>

                                <div class="flex items-center gap-1 mb-4">
                                    <svg v-for="i in 5" :key="i" class="w-5 h-5 text-yellow-400" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
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
                                    <Link :href="route('view')"
                                        class="flex-1 bg-gray-900 text-white px-6 py-3 rounded-xl font-semibold hover:bg-gray-800 transition shadow-md text-center">
                                    View details
                                    </Link>
                                    <button
                                        class="flex-1 bg-gray-900 text-white px-6 py-3 rounded-xl font-semibold hover:bg-gray-800 transition shadow-md">
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
                    <a href="#"
                        class="inline-block bg-yellow-400 text-gray-900 px-10 py-4 rounded-lg font-bold text-lg hover:bg-yellow-500 transition shadow-lg">
                        Get Started Today
                    </a>
                </div>
            </section>
        </LandingAppLayout>

    </div>
</template>

<style scoped>
/* Add custom styles if needed */
</style>
