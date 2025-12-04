<template>
  <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:-translate-y-2 transition-transform">
    <div class="h-64 bg-gray-100 flex items-center justify-center text-6xl">
      {{ product.icon }}
    </div>
    <div class="p-6">
      <h3 class="text-xl font-bold text-gray-900 mb-3">{{ product.name }}</h3>
      <div class="text-3xl font-bold text-yellow-500 mb-3">
        ₱{{ product.price }} <span class="text-sm text-gray-600 font-normal">/day</span>
      </div>
      <div class="flex gap-4 text-sm text-gray-600 mb-4">
        <span>{{ product.spec1 }}</span>
        <span>{{ product.spec2 }}</span>
        <span>⭐ {{ product.rating }}</span>
      </div>
      <button class="w-full bg-gray-900 text-white py-3 rounded-lg font-semibold hover:bg-black transition">
        View Details
      </button>
    </div>
  </div>
</template>

<script setup>
defineProps({
  product: {
    type: Object,
    required: true
  }
})
</script>