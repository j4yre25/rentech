<script setup>
import { ref, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import NavBar from '@/Components/layout/NavBar.vue';
import Footer from '@/Components/layout/Footer.vue';
import ProductCard from '@/Components/common/ProductCard.vue';

const props = defineProps({
  products: {
    type: Array,
    default: () => []
  },
  categories: {
    type: Array,
    default: () => []
  }
});

const selectedCategory = ref('all');

const categoryOptions = computed(() => ([
  { label: 'All gadgets', value: 'all' },
  ...props.categories.map(category => ({
    label: category.name,
    value: String(category.id),
    icon: category.icon ?? null
  }))
]));

const filteredProducts = computed(() => {
  if (selectedCategory.value === 'all') {
    return props.products;
  }
  return props.products.filter(product => String(product.category_id) === selectedCategory.value);
});

const mappedProducts = computed(() => filteredProducts.value.map(product => {
  const rawFeatures = (() => {
    if (Array.isArray(product.features)) {
      return product.features;
    }
    if (typeof product.features === 'string') {
      return product.features
        .split(/[,;|\n]+/)
        .map(item => item.trim())
        .filter(Boolean);
    }
    return [
      product.brand,
      product.model,
      product.condition,
      product.spec1,
      product.spec2,
      product.spec3,
      product.spec4
    ].filter(Boolean);
  })();

  return {
    ...product,
    categoryLabel: product.category ?? product.category_name ?? '',
    price_per_day: product.price_per_day ?? product.price ?? product.daily_rate ?? 0,
    features: rawFeatures.slice(0, 4),
    detailsUrl: product.detailsUrl ?? route('gadgets.show', product.slug ?? product.id)
  };
}));

const handleSelect = (value) => {
  selectedCategory.value = value;
};
</script>

<template>
  <Head title="Browse Gadgets" />

  <div class="min-h-screen bg-gray-50 flex flex-col">
    <NavBar />

    <main class="container mx-auto px-6 py-12 flex-grow">
      <header class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-3">
          Choose your gadget!
        </h1>
        <p class="text-gray-600">
          Browse our curated selection of rentable devices.
        </p>
      </header>

      <section class="flex items-center justify-center gap-3 mb-12 overflow-x-auto pb-4">
        <button
          class="flex-shrink-0 w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center text-gray-600 hover:bg-gray-100 transition"
          aria-label="Scroll categories left"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>

        <div class="flex gap-3">
          <button
            v-for="option in categoryOptions"
            :key="option.value"
            @click="handleSelect(option.value)"
            :class="[
              'px-6 py-2.5 rounded-full font-medium text-sm transition-all whitespace-nowrap flex items-center gap-2',
              selectedCategory === option.value
                ? 'bg-yellow-400 text-gray-900 shadow-md'
                : 'bg-white text-gray-700 hover:bg-gray-100'
            ]"
          >
            <span v-if="option.icon">{{ option.icon }}</span>
            {{ option.label }}
          </button>
        </div>

        <button
          class="flex-shrink-0 w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center text-gray-600 hover:bg-gray-100 transition"
          aria-label="Scroll categories right"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </section>

      <section v-if="mappedProducts.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
        <ProductCard
          v-for="product in mappedProducts"
          :key="product.id"
          :product="product"
        />
      </section>

      <div v-else class="text-center py-20 bg-white rounded-3xl shadow-sm">
        <h2 class="text-2xl font-semibold text-gray-900 mb-3">No gadgets found</h2>
        <p class="text-gray-600">Try a different category or check back later.</p>
      </div>
    </main>

    <Footer />
  </div>
</template>