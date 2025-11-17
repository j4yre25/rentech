<template>
  <footer id="contact" class="bg-white-900 text-white py-16 px-6">
    <div class="container mx-auto">
      <div class="grid md:grid-cols-4 gap-12 mb-12">
        <div>
          <Logo class="mb-4" />
          <p class="text-gray-400 mb-6">
            Rent gadgets with ease and convenience. Connect with us for the latest technology at the best prices.
          </p>
          <div class="flex gap-4">
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-yellow-400 hover:text-gray-900 transition">
              f
            </a>
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-yellow-400 hover:text-gray-900 transition">
              t
            </a>
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-yellow-400 hover:text-gray-900 transition">
              in
            </a>
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-yellow-400 hover:text-gray-900 transition">
              y
            </a>
          </div>
        </div>

        <div>
          <h4 class="text-yellow-400 font-bold text-lg mb-4">Address</h4>
          <p class="text-gray-400">
            123 Tech Street<br>
            Manila, Philippines<br>
            contact@rentech.com
          </p>
        </div>

        <div>
          <h4 class="text-yellow-400 font-bold text-lg mb-4">Useful Links</h4>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition">About us</a></li>
            <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition">Contact</a></li>
            <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition">Blog</a></li>
            <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition">FAQ</a></li>
          </ul>
        </div>

        <div>
          <h4 class="text-yellow-400 font-bold text-lg mb-4">Products</h4>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition">Laptop</a></li>
            <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition">Headphones</a></li>
            <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition">Cameras</a></li>
            <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition">Smartphones</a></li>
          </ul>
        </div>
      </div>

      <div class="border-t border-white-800 pt-8 text-center text-gray-400">
        <p>&copy; 2025 RenTech. All rights reserved.</p>
      </div>
    </div>
  </footer>
</template> 

<script setup>
import Logo from './Logo.vue'
</script>