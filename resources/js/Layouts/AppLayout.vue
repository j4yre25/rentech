<script setup>
import { ref, computed } from 'vue';
import { Link, Head, usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Logo from '@/Components/layout/Logo.vue';
const props = defineProps({
    title: String,
});

const page = usePage();
const showingNavigationDropdown = ref(false);

function logout() {
    Inertia.post(route('logout'));
}

// Helper to determine active state styling
const activeClass = 'bg-yellow-400 text-gray-900 font-medium';
const inactiveClass = 'text-gray-600 hover:bg-gray-50 hover:text-gray-900';
</script>

<template>
    <div class="min-h-screen bg-gray-50 flex flex-col font-sans">
        <Head :title="title" />

        <nav class="bg-white border-b border-yellow-500 shadow-sm z-30 relative">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    
                    <div class="flex items-center gap-4">
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-800 hover:text-gray-900 focus:outline-none">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <Link :href="route('dashboard')" class="flex items-center gap-2 group">
                            <div class="relative">
                                <Logo />
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex gap-0.5">
  
                                </div>
                            </div>
                        </Link>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ml-6 gap-2">
                        
                        <button class="p-2 text-gray-800 hover:text-gray-600 relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </button>

                        <button class="p-2 text-gray-800 hover:text-gray-600 relative mr-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="absolute top-1 right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-white text-gray-900 rounded-full border border-gray-200 shadow-sm">5</span>
                        </button>

                        <div class="ml-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none transition">
                                        <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center text-white font-bold mr-2">
                                            {{ $page.props.auth.user?.name.charAt(0) }}
                                        </div>
                                        <div class="hidden md:block text-left mr-1">
                                            <div class="text-xs text-gray-800 font-bold uppercase tracking-wider">Rentor</div>
                                        </div>
                                        <svg class="ml-2 -mr-0.5 h-4 w-4 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </template>

                                <template #content>
                                    <div class="block px-4 py-2 text-xs text-gray-400">Manage Account</div>
                                    <DropdownLink :href="route('profile.show')">Profile</DropdownLink>
                                    <div class="border-t border-gray-200" />
                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">Log Out</DropdownLink>
                                    </form>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex-1 flex overflow-hidden">
            <aside class="w-64 bg-white flex-shrink-0 border-r border-gray-200 overflow-y-auto hidden sm:block">
                <div class="p-4 space-y-1">
                    
                    <Link :href="route('dashboard')" 
                          class="flex items-center px-4 py-3 rounded-md transition-colors duration-200 group"
                          :class="route().current('dashboard') ? activeClass : inactiveClass">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </Link>

                    <Link :href="route('orders.index')" 
                          class="flex items-center justify-between px-4 py-3 rounded-md transition-colors duration-200 group"
                          :class="route().current('orders.index') ? activeClass : inactiveClass">
                        <div class="flex items-center">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Orders
                        </div>
                        <span class="bg-gray-900 text-white py-0.5 px-2 rounded-full text-xs font-bold">16</span>
                    </Link>

                    <Link :href="route('products.index')" 
                          class="flex items-center px-4 py-3 rounded-md transition-colors duration-200 group"
                          :class="route().current('products.index') ? activeClass : inactiveClass">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        Products
                    </Link>

                    <Link :href="route('categories.index')" 
                          class="flex items-center px-4 py-3 rounded-md transition-colors duration-200 group"
                          :class="route().current('categories.index') ? activeClass : inactiveClass">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Categories
                    </Link>

                    <Link :href="route('customers.index')" 
                          class="flex items-center px-4 py-3 rounded-md transition-colors duration-200 group"
                          :class="route().current('customers.index') ? activeClass : inactiveClass">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Customers
                    </Link>

                    <Link :href="route('reports.index')" 
                          class="flex items-center px-4 py-3 rounded-md transition-colors duration-200 group"
                          :class="route().current('reports.index') ? activeClass : inactiveClass">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Reports
                    </Link>
                    
                     <a href="#" 
                          class="flex items-center px-4 py-3 rounded-md transition-colors duration-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 group">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        Inbox
                    </a>
                </div>
            </aside>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                 <slot />
            </main>
        </div>

        <div :class="{'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown}" class="sm:hidden bg-white border-t border-gray-200">
             <div class="pt-2 pb-3 space-y-1">
                <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                    Dashboard
                </ResponsiveNavLink>
                <ResponsiveNavLink :href="route('orders.index')" :active="route().current('orders.index')">
                    Orders
                </ResponsiveNavLink>
                </div>
        </div>
    </div>
</template>