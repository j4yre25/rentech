<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash'; // Assuming lodash is available, common in Laravel/Inertia apps
import AppLayout from '@/Layouts/AppLayout.vue';
// Props
const props = defineProps({
    orders: Object, // Expecting Laravel Pagination Object
    filters: Object,
});

// State
const search = ref(props.filters.customer || '');
const selectedOrders = ref([]);

// Search Logic (Debounced to prevent API spam)
watch(search, debounce((value) => {
    router.get('/orders', { customer: value }, {
        preserveState: true,
        replace: true,
    });
}, 300));

// Badge Color Logic
const getPaymentStatusClasses = (status) => {
    switch (status) {
        case 'Paid': return 'bg-emerald-100 text-emerald-700';
        case 'Pending': return 'bg-gray-100 text-gray-700';
        default: return 'bg-gray-100 text-gray-700';
    }
};

const getOrderStatusClasses = (status) => {
    switch (status) {
        case 'Renting': return 'bg-orange-100 text-orange-700';
        case 'Done Renting': return 'bg-blue-600 text-white'; // Darker blue style from image
        case 'Received': return 'bg-indigo-600 text-white';
        case 'Ready': return 'bg-amber-400 text-white';
        default: return 'bg-gray-100 text-gray-800';
    }
};

// Toggle all checkboxes
const toggleAll = (e) => {
    if (e.target.checked) {
        selectedOrders.value = props.orders.data.map(order => order.id);
    } else {
        selectedOrders.value = [];
    }
};
</script>

<template>
    <AppLayout title="Orders">
    <div class="min-h-screen bg-gray-50 p-8 font-sans text-gray-900">
        
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Orders</h1>

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            
            <div class="p-4 flex items-center justify-between border-b border-gray-100">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <select class="appearance-none pl-3 pr-8 py-2 border border-gray-300 rounded-md text-sm text-gray-600 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                            <option>Filter</option>
                            <option>Date</option>
                            <option>Status</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input 
                            v-model="search" 
                            type="text" 
                            placeholder="Search..." 
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-indigo-500 focus:border-indigo-500 w-64 placeholder-gray-400"
                        >
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <button class="p-2 text-gray-400 hover:text-gray-600 border border-gray-200 rounded hover:bg-gray-50">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </button>
                    <button class="p-2 text-gray-400 hover:text-red-600 border border-gray-200 rounded hover:bg-gray-50">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white border-b border-gray-200">
                        <tr>
                            <th class="p-4 w-4">
                                <input type="checkbox" @change="toggleAll" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                            </th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Payment status</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Order Status</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr 
                            v-for="order in orders.data" 
                            :key="order.id" 
                            class="hover:bg-gray-50 transition duration-150 ease-in-out"
                        >
                            <td class="p-4">
                                <input 
                                    type="checkbox" 
                                    :value="order.id" 
                                    v-model="selectedOrders" 
                                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4"
                                >
                            </td>
                            <td class="px-4 py-3 text-sm font-semibold text-gray-700">#{{ order.order_number }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ order.order_date }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ order.customer_name }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span 
                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded"
                                    :class="getPaymentStatusClasses(order.payment_status)"
                                >
                                    {{ order.payment_status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <span 
                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded"
                                    :class="getOrderStatusClasses(order.order_status)"
                                >
                                    {{ order.order_status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-700">₱{{ order.total }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Previous </a>
                    <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"> Next </a>
                </div>
                
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <template v-for="(link, key) in orders.links" :key="key">
                                <div
                                    v-if="link.url === null"
                                    class="relative inline-flex items-center px-2 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-default"
                                    v-html="link.label"
                                ></div>
                                <Link
                                    v-else
                                    :href="link.url"
                                    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                                    :class="link.active ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'"
                                    v-html="link.label"
                                />
                            </template>
                        </nav>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">
                            {{ orders.total }} Results
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </AppLayout>
</template>