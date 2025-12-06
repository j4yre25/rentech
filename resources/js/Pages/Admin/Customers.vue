<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash'; 
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue'; // Assumes you have a pagination component, or use the loop logic below

const props = defineProps({
    rentees: {
        type: Object,
        required: true,
    },
    filters: Object,
});

const search = ref(props.filters?.search || '');
const selectedRentees = ref([]);

// Search Logic
watch(search, debounce((value) => {
    router.get('/rentees', { search: value }, {
        preserveState: true,
        replace: true,
    });
}, 300));

// Avatar Logic (Generates Initials and Random Color)
const getInitials = (name) => {
    return name
        .split(' ')
        .map(n => n[0])
        .slice(0, 2)
        .join('')
        .toUpperCase();
};

const getAvatarColor = (id) => {
    const colors = [
        'bg-indigo-100 text-indigo-600',
        'bg-blue-100 text-blue-600',
        'bg-gray-200 text-gray-600',
        'bg-purple-100 text-purple-600',
        'bg-pink-100 text-pink-600',
    ];
    return colors[id % colors.length];
};

// Selection Logic
const toggleAll = (e) => {
    if (e.target.checked) {
        selectedRentees.value = props.rentees.data.map(r => r.id);
    } else {
        selectedRentees.value = [];
    }
};
</script>

<template>
    <AppLayout title="Rentees">
        <div class="min-h-screen bg-gray-50 p-8 font-sans text-gray-900">
            
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Rentees</h1>

            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                
                <div class="px-6 pt-4 pb-0 border-b border-gray-100 flex gap-6">
                    <button class="pb-4 border-b-2 border-indigo-500 text-indigo-600 font-medium text-sm">
                        All Rentees
                    </button>
                    <button class="pb-4 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm transition">
                        New Rentees
                    </button>
                </div>

                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <select class="appearance-none pl-3 pr-8 py-2 border border-gray-300 rounded-md text-sm text-gray-600 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                                <option>Filter</option>
                                <option>Active</option>
                                <option>Inactive</option>
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
                        <button class="p-2 text-indigo-500 hover:bg-indigo-50 rounded border border-indigo-100 transition">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>
                        <button class="p-2 text-red-500 hover:bg-red-50 rounded border border-red-100 transition">
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
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Location (Address)</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Payout</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr 
                                v-for="rentee in rentees.data" 
                                :key="rentee.id" 
                                class="hover:bg-gray-50 transition duration-150 ease-in-out group"
                            >
                                <td class="p-4">
                                    <input 
                                        type="checkbox" 
                                        :value="rentee.id" 
                                        v-model="selectedRentees" 
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4"
                                    >
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div 
                                            class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center font-bold text-sm"
                                            :class="getAvatarColor(rentee.id)"
                                        >
                                            {{ getInitials(rentee.name) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">{{ rentee.name }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ rentee.address }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ rentee.phone }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right text-gray-900">
                                    {{ rentee.payout_type }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <button :disabled="!rentees.prev_page_url" class="p-2 text-gray-400 hover:text-gray-600 disabled:opacity-30">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </button>
                        
                        <div class="flex space-x-1">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded text-sm font-medium">1</span>
                            <span class="px-3 py-1 text-gray-600 hover:bg-gray-50 rounded text-sm cursor-pointer">2</span>
                            <span class="px-3 py-1 text-gray-600 hover:bg-gray-50 rounded text-sm cursor-pointer">3</span>
                            <span class="px-3 py-1 text-gray-600">...</span>
                        </div>

                        <button :disabled="!rentees.next_page_url" class="p-2 text-gray-400 hover:text-gray-600 disabled:opacity-30">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>

                    <div class="text-sm text-gray-500">
                        {{ rentees.total || 0 }} Results
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>