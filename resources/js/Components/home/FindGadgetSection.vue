<template>
  <section class="mx-6 my-16">
    <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-[50px] px-6 py-16">
      <div class="container mx-auto">
        <div class="grid md:grid-cols-2 gap-12 items-center">
          <div>
            <h2 class="text-4xl font-bold text-gray-900 mb-6">Find the Right Gadget Near You</h2>
            <p class="text-lg text-gray-800 mb-8">
              Discover the latest tech gadgets available for rent in your area. 
              Quick, easy, and affordable rentals at your fingertips.
            </p>
            <div class="flex gap-4">
              <input 
                v-model="location"
                type="text" 
                placeholder="Enter your location"
                class="flex-1 px-6 py-4 rounded-full border-none focus:outline-none focus:ring-2 focus:ring-gray-900"
              >
              <button class="bg-gray-900 text-white px-8 py-4 rounded-full font-semibold hover:bg-black transition">
                Search
              </button>
            </div>
          </div>

          <div class="grid grid-cols-3 gap-6">
            <div 
              v-for="(icon, index) in icons" 
              :key="index" 
              class="bg-white bg-opacity-30 rounded-2xl p-8 text-center text-5xl backdrop-blur-sm"
            >
              {{ icon }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

const location = ref('')
const icons = ['🎧', '💻', '📱', '💾', '🖨️', '📷']
</script>