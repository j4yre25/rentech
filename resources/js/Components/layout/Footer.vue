<template>
  <footer class="bg-white-900 text-black py-12 px-6">
    <div class="container mx-auto">
      <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-8 mb-8">
        <!-- Brand Section -->
        <div class="lg:col-span-2">
          <div class="flex items-center gap-2">
            <Link :href="route('home')">
              <img src="/images/logo.png" alt="RenTech Logo" class="w-28 h-auto cursor-pointer hover:scale-105 transition-transform" />
            </Link>
          </div>
          <p class="text-black-400 mb-6 leading-relaxed">
            Rent gadgets with ease and convenience. Connect with verified renters and find the tools you need in just a few clicks.
          </p>
          <div class="flex gap-3">
            <a href="#" class="w-9 h-9 bg-yellow-500 rounded-full flex items-center justify-center hover:bg-yellow-400 transition">
              <span class="text-sm font-bold">f</span>
            </a>
            <a href="#" class="w-9 h-9 bg-yellow-500 rounded-full flex items-center justify-center hover:bg-yellow-400 transition">
              <span class="text-sm font-bold">in</span>
            </a>
            <a href="#" class="w-9 h-9 bg-yellow-500 rounded-full flex items-center justify-center hover:bg-yellow-400 transition">
              <span class="text-sm font-bold">tw</span>
            </a>
            <a href="#" class="w-9 h-9 bg-yellow-500 rounded-full flex items-center justify-center hover:bg-yellow-400 transition">
              <span class="text-sm font-bold">yt</span>
            </a>
          </div>
        </div>

        <!-- Address -->
        <div>
          <div class="flex items-start gap-3 mb-4">
            <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
              <span class="text-black-900 text-sm">📍</span>
            </div>
            <div>
              <h4 class="font-semibold mb-1">Address</h4>
              <p class="text-black-400 text-sm">General Santos City, Philippines</p>
            </div>
          </div>

          <div class="flex items-start gap-3 mb-4">
            <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
              <span class="text-black-900 text-sm">📧</span>
            </div>
            <div>
              <h4 class="font-semibold mb-1">Email</h4>
              <p class="text-black-400 text-sm">rentechph@gmail.com</p>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
              <span class="text-black-900 text-sm">📞</span>
            </div>
            <div>
              <h4 class="font-semibold mb-1">Phone</h4>
              <p class="text-black-400 text-sm">+63 912 345 6789</p>
            </div>
          </div>
        </div>

        <!-- Useful Links -->
        <FooterColumn 
          title="Useful links"
          :links="[
            { name: 'About us', href: '#about' },
            { name: 'Contact us', href: '#contact' },
            { name: 'Gallery', href: '#gallery' },
            { name: 'Blog', href: '#blog' },
            { name: 'F.A.Q', href: '#faq' }
          ]"
        />

        <!-- Devices -->
        <FooterColumn 
          title="Devices"
          :links="deviceLinks"
        />
      </div>

      <div class="border-t border-black-800 pt-6 text-center">
        <p class="text-black-400 text-sm">
          &copy; {{ currentYear }} RenTech Philippines. All rights reserved.
        </p>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { computed } from 'vue';
import FooterColumn from './FooterColumn.vue';
import { Link } from '@inertiajs/vue3';

const currentYear = new Date().getFullYear();

const deviceLinks = computed(() => [
  { name: 'Laptops', href: route('gadgets.list') + '?category=laptops' },
  { name: 'Speakers', href: route('gadgets.list') + '?category=speakers' },
  { name: 'VR Headsets', href: route('gadgets.list') + '?category=vr' },
  { name: 'Projectors', href: route('gadgets.list') + '?category=projectors' },
  { name: 'Tablets', href: route('gadgets.list') + '?category=tablets' },
  { name: 'Headphones', href: route('gadgets.list') + '?category=headphones' },
  { name: 'Printers', href: route('gadgets.list') + '?category=printers' },
  { name: 'Microphone', href: route('gadgets.list') + '?category=microphones' },
  { name: 'Cameras', href: route('gadgets.list') + '?category=cameras' },
  { name: 'Drones', href: route('gadgets.list') + '?category=drones' }
]);
</script>