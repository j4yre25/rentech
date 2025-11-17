<template>
  <section id="gadgets" class="py-16 px-6">
    <div class="container mx-auto">
      <div class="flex justify-between items-center mb-12">
        <h2 class="text-4xl font-bold text-gray-900">Choose the gadget that suits your needs</h2>
        <a href="#" class="text-gray-900 font-semibold hover:text-yellow-500 flex items-center gap-2">
          View All →
        </a>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <ProductCard 
          v-for="product in products" 
          :key="product.id"
          :product="product"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import ProductCard from '../common/ProductCard.vue'

const products = ref([
  {
    id: 1,
    name: 'Apple MacBook Air',
    price: 500,
    icon: '💻',
    spec1: '📱 M1',
    spec2: '💾 256GB',
    rating: 4.8
  },
  {
    id: 2,
    name: 'Samsung Galaxy Tab S8',
    price: 300,
    icon: '📱',
    spec1: '📱 11"',
    spec2: '💾 128GB',
    rating: 4.6
  },
  {
    id: 3,
    name: 'Sony WH-1000XM5',
    price: 150,
    icon: '🎧',
    spec1: '🎧 Wireless',
    spec2: '🔋 30hrs',
    rating: 4.9
  },
  {
    id: 4,
    name: 'Canon EOS 90D Mark II',
    price: 800,
    icon: '📷',
    spec1: '📷 32MP',
    spec2: '🎥 4K',
    rating: 4.7
  },
  {
    id: 5,
    name: 'Lenovo ThinkPad X1',
    price: 600,
    icon: '💼',
    spec1: '💻 i7',
    spec2: '💾 512GB',
    rating: 4.5
  },
  {
    id: 6,
    name: 'GoPro Hero 12 Black',
    price: 400,
    icon: '📹',
    spec1: '📹 5.3K',
    spec2: '💧 Waterproof',
    rating: 4.8
  }
])
</script>