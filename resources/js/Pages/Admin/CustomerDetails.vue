<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    customer: {
        type: Object,
        default: () => ({
            id: 1,
            name: 'Randhir Kumar',
            initials: 'R',
            email: 'randhirppl@gmail.com',
            phone: '+91 8804789764',
            address: 'Panapur langa, Hajipur, Vaishali 844124, India',
            location: 'India',
            orders_count: 5,
            years_active: 2,
            rating: 5,
            notes: '',
            tags: [],
            recent_orders: [
                { id: '#23534D', date: 'May 25, 3:12 PM', status: 'Pending', price: '29.74' },
                { id: '#12512B', date: 'May 10, 2:00 PM', status: 'Completed', price: '23.06' },
                { id: '#23534D', date: 'April 18, 8:00 AM', status: 'Completed', price: '29.74' },
                { id: '#76543E', date: 'April 12, 8:00 AM', status: 'Completed', price: '23.06' },
                { id: '#51323C', date: 'April 10, 4:12 PM', status: 'Completed', price: '23.06' },
            ]
        }),
    },
});

const form = useForm({
    notes: props.customer.notes,
    tags: Array.isArray(props.customer.tags) ? [...props.customer.tags] : [],
    new_tag: ''
});

const addTag = () => {
    if (form.new_tag.trim()) {
        form.tags.push(form.new_tag);
        form.new_tag = '';
    }
};

const removeTag = (index) => {
    form.tags.splice(index, 1);
};

const getStatusClass = (status) => {
    if (status === 'Completed') return 'bg-emerald-100 text-emerald-600';
    if (status === 'Pending') return 'bg-gray-100 text-gray-600';
    return 'bg-gray-100 text-gray-600';
};
</script>

<template>
    <AppLayout title="Customer Information">
        <div class="min-h-screen bg-gray-50 p-8 font-sans text-gray-900">
            
            <div class="max-w-7xl mx-auto mb-6">
                <Link :href="route('customers.index')" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back
                </Link>
                <h1 class="text-2xl font-bold text-gray-900">Customer Information</h1>
            </div>

            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-4">
                                <div class="h-16 w-16 rounded-full bg-slate-400 flex items-center justify-center text-white text-2xl font-medium">
                                    {{ customer.initials }}
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-gray-900">{{ customer.name }}</h2>
                                    <p class="text-sm text-gray-500 mb-1">{{ customer.location }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ customer.orders_count }} Orders <span class="mx-1">•</span> Customer for {{ customer.years_active }} years
                                    </p>
                                </div>
                            </div>
                            <div class="flex text-yellow-400">
                                <svg v-for="i in 5" :key="i" class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <h3 class="text-base font-bold text-gray-900 mb-4">Customer Notes</h3>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Notes</label>
                            <textarea 
                                v-model="form.notes" 
                                placeholder="Add notes about customer" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm placeholder-gray-400 h-24 resize-none"
                            ></textarea>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <h3 class="text-base font-bold text-gray-900 mb-4">Customer Orders</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="border-b border-gray-100">
                                        <th class="pb-3 text-xs font-medium text-gray-400 uppercase">Order</th>
                                        <th class="pb-3 text-xs font-medium text-gray-400 uppercase">Date</th>
                                        <th class="pb-3 text-xs font-medium text-gray-400 uppercase">Order Status</th>
                                        <th class="pb-3 text-xs font-medium text-gray-400 uppercase text-right">Price</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    <tr v-for="order in customer.recent_orders" :key="order.id">
                                        <td class="py-4 text-sm font-medium text-gray-900">{{ order.id }}</td>
                                        <td class="py-4 text-sm text-gray-600">{{ order.date }}</td>
                                        <td class="py-4">
                                            <span 
                                                class="px-2 py-1 text-xs font-semibold rounded bg-gray-100"
                                                :class="getStatusClass(order.status)"
                                            >
                                                {{ order.status }}
                                            </span>
                                        </td>
                                        <td class="py-4 text-sm font-medium text-gray-900 text-right">${{ order.price }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="space-y-6">
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <h3 class="text-base font-bold text-gray-900 mb-4">Overview</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs text-gray-400 mb-1">Address</label>
                                <p class="text-sm text-gray-600">{{ customer.address }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-xs text-gray-400 mb-1">Email Address</label>
                                <p class="text-sm text-gray-600">{{ customer.email }}</p>
                            </div>

                            <div>
                                <label class="block text-xs text-gray-400 mb-1">Phone</label>
                                <p class="text-sm text-gray-600">{{ customer.phone }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <h3 class="text-base font-bold text-gray-900 mb-4">Tags</h3>
                        
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Add Tags</label>
                            <input 
                                v-model="form.new_tag" 
                                @keydown.enter.prevent="addTag"
                                type="text" 
                                placeholder="Enter tag name" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm placeholder-gray-400"
                            >
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <span 
                                v-for="(tag, index) in form.tags" 
                                :key="index"
                                class="inline-flex items-center px-3 py-1 rounded bg-slate-200 text-slate-700 text-xs font-medium"
                            >
                                {{ tag }}
                                <button 
                                    @click="removeTag(index)"
                                    class="ml-2 text-slate-500 hover:text-slate-800"
                                >
                                    ×
                                </button>
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="max-w-7xl mx-auto mt-6 flex justify-end gap-3 pb-8">
                <button class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-blue-600 hover:bg-gray-50 shadow-sm">
                    Cancel
                </button>
                <button class="px-6 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 shadow-sm">
                    Save
                </button>
            </div>

        </div>
    </AppLayout>
</template>