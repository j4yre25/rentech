<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

// Assuming you have registered the component globally, otherwise uncomment below:
// import VueApexCharts from 'vue3-apexcharts';

const props = defineProps({
    orders: { type: Array, required: true },
    products: { type: Array, required: true },
    categories: { type: Array, required: true },
    rentees: { type: Array, required: true },
});

// --- Chart Configurations & Mock Data to match Design ---

// 1. Customer Growth (Bar Chart)
const growthSeries = ref([
    { name: 'Returning customers', data: [44, 55, 41, 67, 22, 43, 21, 33, 45, 31, 87, 65] },
    { name: 'New customers', data: [13, 23, 20, 8, 13, 27, 33, 12, 16, 19, 11, 14] }
]);
const growthOptions = ref({
    chart: { type: 'bar', toolbar: { show: false } },
    colors: ['#E0E7FF', '#2563EB'], // Light Indigo, Dark Blue
    plotOptions: { bar: { horizontal: false, columnWidth: '30%', borderRadius: 2 } },
    dataLabels: { enabled: false },
    stroke: { show: true, width: 2, colors: ['transparent'] },
    xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], axisBorder: { show: false }, axisTicks: { show: false } },
    yaxis: { show: false }, // Hiding y-axis labels to match clean look
    grid: { borderColor: '#f3f4f6', strokeDashArray: 4 },
    legend: { position: 'top', horizontalAlign: 'left' }
});

// 2. Sales Goal (Radial Bar)
const goalSeries = ref([75]);
const goalOptions = ref({
    chart: { type: 'radialBar', sparkline: { enabled: true } },
    colors: ['#FBBF24'], // Amber/Yellow
    plotOptions: {
        radialBar: {
            hollow: { size: '60%' },
            dataLabels: {
                name: { show: false },
                value: { offsetY: 5, fontSize: '18px', fontWeight: 'bold', color: '#111827' }
            }
        }
    }
});

// 3. Conversion Rate (Radial Bar)
const conversionSeries = ref([25]);
const conversionOptions = ref({
    chart: { type: 'radialBar', sparkline: { enabled: true } },
    colors: ['#10B981'], // Emerald/Green
    plotOptions: {
        radialBar: {
            hollow: { size: '60%' },
            dataLabels: {
                name: { show: false },
                value: { offsetY: 5, fontSize: '18px', fontWeight: 'bold', color: '#111827' }
            }
        }
    }
});

// 4. Avg Order Value (Line Area)
const avgOrderSeries = ref([{ name: 'Value', data: [20, 15, 25, 20, 22, 35, 25, 30] }]);
const avgOrderOptions = ref({
    chart: { type: 'line', toolbar: { show: false }, sparkline: { enabled: false } },
    colors: ['#3B82F6'],
    stroke: { curve: 'smooth', width: 3 },
    xaxis: { categories: ['4am', '8am', '12pm', '4pm', '8pm', 'Jun 12'], labels: { style: { colors: '#9CA3AF', fontSize: '10px' } }, axisBorder: { show: false }, axisTicks: { show: false } },
    yaxis: { show: true, tickAmount: 3, labels: { style: { colors: '#9CA3AF' } } },
    grid: { show: false }
});

// 5. Store Funnel (Bar)
const funnelSeries = ref([{ name: 'Visitors', data: [400, 330, 240, 150] }]);
const funnelOptions = ref({
    chart: { type: 'bar', toolbar: { show: false } },
    colors: ['#2563EB'],
    plotOptions: { bar: { borderRadius: 4, columnWidth: '40%' } },
    dataLabels: { enabled: false },
    xaxis: { categories: ['Visited Site', 'Added to Cart', 'Proceed to Checkout', 'Made a Purchase'], axisBorder: { show: false }, axisTicks: { show: false } },
    yaxis: { show: true, labels: { style: { colors: '#9CA3AF' } } },
    grid: { show: false }
});

// 6. Age Distribution (Donut)
const ageSeries = ref([50, 30, 10, 10]);
const ageOptions = ref({
    chart: { type: 'donut' },
    colors: ['#3B82F6', '#FBBF24', '#F87171', '#10B981'],
    labels: ['0-18 years', '18-30 years', '30-40 years', 'Other'],
    dataLabels: { enabled: false },
    legend: { position: 'bottom', horizontalAlign: 'left', fontSize: '12px' },
    plotOptions: { pie: { donut: { size: '75%' } } }
});

// Mock Data for Tables/Lists
const stats = [
    { title: 'Existing Users', value: '5,653', change: '22.45%', up: true },
    { title: 'New Users', value: '1,650', change: '15.34%', up: true },
    { title: 'Total Visits', value: '9,504', change: '18.25%', up: false },
    { title: 'Unique Visits', value: '5,423', change: '10.24%', up: false },
];

const visitsByDevice = [
    { name: 'Mobile', value: '62%', icon: 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z' },
    { name: 'Laptop', value: '20%', icon: 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z' },
    { name: 'Tablet', value: '13%', icon: 'M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z' },
    { name: 'Other', value: '5%', icon: 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z' },
];

const topCustomers = [
    { name: 'Lee Henry', orders: 52, spent: '$969.37', initials: 'A', color: 'bg-blue-600' },
    { name: 'Myrtle McBride', orders: 42, spent: '$859.64', initials: 'M', color: 'bg-blue-600' },
    { name: 'Tommy Walker', orders: 41, spent: '$726.08', initials: 'T', color: 'bg-blue-600' },
    { name: 'Luis Cannon', orders: 30, spent: '$670.42', initials: 'L', color: 'bg-blue-600' },
    { name: 'Jimmy Cook', orders: 24, spent: '$549.21', initials: 'J', color: 'bg-blue-600' },
];

const topProducts = [
    { name: 'Men White T-Shirt', clicks: '12,040', sold: 195, image: 'https://via.placeholder.com/40' },
    { name: 'Women White T-Shirt', clicks: '11,235', sold: 158, image: 'https://via.placeholder.com/40' },
    { name: 'Women Striped T-Shirt', clicks: '10,064', sold: 122, image: 'https://via.placeholder.com/40' },
    { name: 'Men Grey Hoodie', clicks: '8,485', sold: 110, image: 'https://via.placeholder.com/40' },
    { name: 'Women Red T-Shirt', clicks: '5,605', sold: 97, image: 'https://via.placeholder.com/40' },
];
</script>

<template>
    <AppLayout title="Reports">
        <div class="min-h-screen bg-gray-50 p-6 md:p-8 font-sans text-gray-900">
            
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Reports</h1>

            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Customer Growth</h2>
                    <select class="text-sm border-none text-gray-500 bg-transparent focus:ring-0 cursor-pointer">
                        <option>Last 12 Months</option>
                    </select>
                </div>
                <div class="h-80 w-full">
                    <apexchart type="bar" height="100%" :options="growthOptions" :series="growthSeries"></apexchart>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div v-for="stat in stats" :key="stat.title" class="bg-white rounded-lg shadow-sm p-6">
                    <p class="text-sm text-gray-500 font-medium mb-1">{{ stat.title }}</p>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ stat.value }}</h3>
                    <p class="text-xs font-medium flex items-center" :class="stat.up ? 'text-green-500' : 'text-red-500'">
                        {{ stat.change }}
                        <span class="ml-1 text-gray-400 font-normal">vs last month</span>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-sm font-bold text-gray-800 mb-4">Sales Goal</h2>
                    <div class="flex justify-center mb-4">
                         <apexchart type="radialBar" height="160" :options="goalOptions" :series="goalSeries"></apexchart>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Sold</span>
                            <span class="font-bold text-gray-900">$15,000</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Month goal</span>
                            <span class="font-bold text-gray-900">$20,000</span>
                        </div>
                        <div class="flex justify-between border-t border-gray-100 pt-2">
                            <span class="text-gray-500">Left</span>
                            <span class="font-bold text-gray-900">$5,000</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-sm font-bold text-gray-800 mb-4">Conversion Rate</h2>
                    <div class="flex justify-center mb-4">
                         <apexchart type="radialBar" height="160" :options="conversionOptions" :series="conversionSeries"></apexchart>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Cart</span>
                            <span class="font-bold text-gray-900">35%</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Checkout</span>
                            <span class="font-bold text-gray-900">28%</span>
                        </div>
                        <div class="flex justify-between border-t border-gray-100 pt-2">
                            <span class="text-gray-500">Purchase</span>
                            <span class="font-bold text-gray-900">25%</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-sm font-bold text-gray-800 mb-2">Average Order Value</h2>
                    <p class="text-xs text-gray-500 mb-4">This Month: <span class="font-bold text-gray-900">$48.90</span></p>
                    <div class="h-48">
                         <apexchart type="line" height="100%" :options="avgOrderOptions" :series="avgOrderSeries"></apexchart>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="text-sm font-bold text-gray-800">Customer Demographics</h2>
                        <div class="flex flex-col gap-1">
                            <button class="w-6 h-6 flex items-center justify-center bg-gray-100 rounded text-gray-600 hover:bg-gray-200">+</button>
                            <button class="w-6 h-6 flex items-center justify-center bg-gray-100 rounded text-gray-600 hover:bg-gray-200">-</button>
                        </div>
                    </div>
                    <div class="relative h-64 bg-gray-50 rounded border border-gray-100 flex items-center justify-center overflow-hidden">
                         <span class="text-gray-400 text-sm font-medium tracking-wider">[ Interactive World Map Placeholder ]</span>
                         <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 20px 20px;"></div>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-6">
                        <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-600"></span> <span class="text-xs font-bold">United States <span class="block font-normal text-gray-500">29,051</span></span></div>
                        <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-400"></span> <span class="text-xs font-bold">Europe <span class="block font-normal text-gray-500">18,041</span></span></div>
                        <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-yellow-400"></span> <span class="text-xs font-bold">Australia <span class="block font-normal text-gray-500">10,430</span></span></div>
                        <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-gray-300"></span> <span class="text-xs font-bold">Other <span class="block font-normal text-gray-500">5,420</span></span></div>
                    </div>
                </div>

                <div class="flex flex-col gap-6">
                    <div class="bg-white rounded-lg shadow-sm p-6 flex-1">
                        <h2 class="text-sm font-bold text-gray-800 mb-4">Visits by Device</h2>
                        <div class="space-y-4">
                            <div v-for="device in visitsByDevice" :key="device.name" class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="device.icon"></path></svg>
                                    <span class="text-sm text-gray-600">{{ device.name }}</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ device.value }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-sm font-bold text-gray-800 mb-1">Online Sessions</h2>
                        <div class="flex items-center gap-2">
                            <h3 class="text-2xl font-bold text-gray-900">128</h3>
                            <span class="text-xs text-green-500 font-bold bg-green-50 px-1 rounded">↑</span>
                        </div>
                        <p class="text-xs text-gray-500">Active Users</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-sm font-bold text-gray-800 mb-4">Top Customers</h2>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="pb-2 text-xs font-medium text-gray-400">Name</th>
                                <th class="pb-2 text-xs font-medium text-gray-400">Orders</th>
                                <th class="pb-2 text-xs font-medium text-gray-400 text-right">Spent</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr v-for="customer in topCustomers" :key="customer.name">
                                <td class="py-3 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold" :class="customer.color">{{ customer.initials }}</div>
                                    <span class="text-sm text-gray-700 font-medium">{{ customer.name }}</span>
                                </td>
                                <td class="py-3 text-sm text-gray-600">{{ customer.orders }}</td>
                                <td class="py-3 text-sm text-gray-700 font-medium text-right">{{ customer.spent }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-sm font-bold text-gray-800 mb-4">Top Products</h2>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="pb-2 text-xs font-medium text-gray-400">Name</th>
                                <th class="pb-2 text-xs font-medium text-gray-400">Clicks</th>
                                <th class="pb-2 text-xs font-medium text-gray-400">Units Sold</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <tr v-for="product in topProducts" :key="product.name">
                                <td class="py-3 flex items-center gap-3">
                                    <div class="w-8 h-8 bg-gray-100 rounded flex-shrink-0"></div> <span class="text-sm text-gray-700 font-medium">{{ product.name }}</span>
                                </td>
                                <td class="py-3 text-sm text-gray-600">{{ product.clicks }}</td>
                                <td class="py-3 text-sm text-gray-600">{{ product.sold }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center gap-3">
                            <h2 class="text-sm font-bold text-gray-800">Store Funnel</h2>
                            <p class="text-xs text-gray-500">Conversion Rate 28% <span class="text-green-500 bg-green-50 px-1 py-0.5 rounded ml-1">4% Increase</span></p>
                        </div>
                        <select class="text-xs border-none text-gray-500 bg-transparent focus:ring-0 cursor-pointer">
                            <option>Last 7 Days</option>
                        </select>
                    </div>
                    <div class="h-64">
                         <apexchart type="bar" height="100%" :options="funnelOptions" :series="funnelSeries"></apexchart>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-sm font-bold text-gray-800 mb-4">Age Distribution</h2>
                    <div class="h-64 flex flex-col justify-center">
                         <apexchart type="donut" height="100%" :options="ageOptions" :series="ageSeries"></apexchart>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="#" class="text-xs text-blue-500 hover:underline">Find out more</a>
                    </div>
                </div>
            </div>

        </div>
    </AppLayout>
</template>