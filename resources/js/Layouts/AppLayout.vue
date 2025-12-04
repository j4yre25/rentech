<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm sticky top-0 z-50">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <Link :href="route('home')" class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center">
                            <span class="text-gray-900 font-bold text-xl">R</span>
                        </div>
                        <span class="text-2xl font-bold text-gray-900">RenTech</span>
                    </Link>
                    
                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center gap-8">
                        <Link 
                            :href="route('home')" 
                            class="text-gray-700 hover:text-yellow-600 font-medium transition"
                        >
                            Home
                        </Link>
                        <Link 
                            :href="route('products.index')" 
                            class="text-gray-700 hover:text-yellow-600 font-medium transition"
                        >
                            Browse
                        </Link>
                        <a href="#how-it-works" class="text-gray-700 hover:text-yellow-600 font-medium transition">
                            How it Works
                        </a>
                        <a href="#contact" class="text-gray-700 hover:text-yellow-600 font-medium transition">
                            Contact
                        </a>
                    </div>
                    
                    <!-- Auth Buttons -->
                    <div class="hidden md:flex items-center gap-4">
                        <a href="#" class="text-gray-700 hover:text-yellow-600 font-medium transition">
                            Login
                        </a>
                        <a href="#" class="bg-yellow-400 text-gray-900 px-6 py-2 rounded-lg font-semibold hover:bg-yellow-500 transition">
                            Sign Up
                        </a>
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <button 
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden text-gray-700 hover:text-yellow-600"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                :d="mobileMenuOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'"
                            />
                        </svg>
                    </button>
                </div>
                
                <!-- Mobile Menu -->
                <div v-if="mobileMenuOpen" class="md:hidden border-t border-gray-100 py-4">
                    <div class="flex flex-col space-y-3">
                        <Link :href="route('home')" class="text-gray-700 hover:text-yellow-600 font-medium">
                            Home
                        </Link>
                        <Link :href="route('products.index')" class="text-gray-700 hover:text-yellow-600 font-medium">
                            Browse
                        </Link>
                        <a href="#how-it-works" class="text-gray-700 hover:text-yellow-600 font-medium">
                            How it Works
                        </a>
                        <a href="#contact" class="text-gray-700 hover:text-yellow-600 font-medium">
                            Contact
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12 mt-20">
            <div class="container mx-auto px-4">
                <div class="grid md:grid-cols-4 gap-8">
                    <!-- Brand -->
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center">
                                <span class="text-gray-900 font-bold text-xl">R</span>
                            </div>
                            <span class="text-2xl font-bold">RenTech</span>
                        </div>
                        <p class="text-gray-400 mb-4">
                            Rent gadgets and stay up-to-date with cutting-edge technology
                        </p>
                    </div>

                    <!-- Company -->
                    <div>
                        <h4 class="font-bold mb-4 text-lg">Company</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition">About Us</a></li>
                            <li><a href="#" class="hover:text-white transition">How it Works</a></li>
                            <li><a href="#" class="hover:text-white transition">Careers</a></li>
                            <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div>
                        <h4 class="font-bold mb-4 text-lg">Support</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition">Help Center</a></li>
                            <li><a href="#" class="hover:text-white transition">Contact Us</a></li>
                            <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                            <li><a href="#" class="hover:text-white transition">Shipping Info</a></li>
                        </ul>
                    </div>

                    <!-- Legal -->
                    <div>
                        <h4 class="font-bold mb-4 text-lg">Legal</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                            <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-white transition">Rental Agreement</a></li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; {{ new Date().getFullYear() }} RenTech. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const mobileMenuOpen = ref(false);
</script>