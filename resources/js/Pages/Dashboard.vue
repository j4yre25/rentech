<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { Link, Head, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import LandingAppLayout from '@/Components/layout/LandingAppLayout.vue';
import NavBar from '@/Components/layout/NavBar.vue';
import VueApexCharts from 'vue3-apexcharts';import HomePage from '@/Pages/Customer/HomePage.vue';


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
        <HomePage />
        
        

    </div>
</template>

<style scoped>
/* Add custom styles if needed */
</style>
