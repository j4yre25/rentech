<template>
  <header class="sticky top-0 z-50 bg-white shadow-md">
    <nav class="container mx-auto px-6 py-4">
      <div class="flex items-center justify-between">
        <!-- Logo -->
        <Logo />

        <!-- Navigation Links -->
        <ul class="hidden md:flex items-center gap-8">
          <li v-for="link in navLinks" :key="link.name">
            <a 
              :href="link.href" 
              class="text-gray-700 hover:text-yellow-500 font-medium transition"
            >
              {{ link.name }}
            </a>
          </li>
        </ul>

        <!-- Actions -->
        <div class="flex items-center gap-4">
          <a :href="route('login')" class="text-gray-700 font-medium hover:text-yellow-500 transition">
            Sign in
          </a>
          <a 
            :href="route('register')" 
            class="bg-gray-900 text-white px-6 py-2 rounded-full font-medium hover:bg-black transition"
          >
            Sign Up
          </a>
        </div>
      </div>
    </nav>
  </header>
</template>

<script setup>
import Logo from './Logo.vue'

const navLinks = [
  { name: 'Home', href: '#home' },
  { name: 'Gadgets', href: '#gadgets' },
  { name: 'Details', href: '#details' },
  { name: 'About Us', href: '#about' },
  { name: 'Contact Us', href: '#contact' }
]
</script>