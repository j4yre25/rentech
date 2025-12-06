<template>
  <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:-translate-y-2 transition-transform duration-200">
    <div class="h-64 bg-gray-100 flex items-center justify-center">
      <img
        v-if="imageUrl"
        :src="imageUrl"
        :alt="product.name"
        class="max-h-full max-w-full object-contain"
        loading="lazy"
      >
      <span v-else class="text-6xl">{{ fallbackIcon }}</span>
    </div>

    <div class="p-6">
      <h3 class="text-xl font-bold text-gray-900 mb-1">{{ product.name }}</h3>
      <p v-if="categoryLabel" class="text-sm text-gray-500 mb-3">{{ categoryLabel }}</p>

      <div class="text-3xl font-bold text-yellow-500 mb-3">
        ₱{{ priceLabel }}
        <span class="text-sm text-gray-600 font-normal">/day</span>
      </div>

      <div class="flex flex-wrap gap-2 text-sm text-gray-600 mb-6">
        <span
          v-for="feature in featureList"
          :key="feature"
          class="inline-flex items-center gap-2 bg-gray-100 px-3 py-1 rounded-full"
        >
          <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          {{ feature }}
        </span>
      </div>

      <div class="flex flex-col sm:flex-row gap-3">
        <Link
          v-if="detailsUrl"
          :href="detailsUrl"
          class="flex-1 min-w-[140px] bg-gray-900 text-white py-3 rounded-lg font-semibold hover:bg-black transition text-center inline-flex items-center justify-center"
        >
          View Details
        </Link>
        <button
          v-else
          class="flex-1 min-w-[140px] bg-gray-300 text-gray-600 py-3 rounded-lg font-semibold cursor-not-allowed"
          disabled
        >
          View Details
        </button>

        <Link
          v-if="rentUrl"
          :href="rentUrl"
          class="flex-1 min-w-[140px] border border-gray-900 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-900 hover:text-white transition text-center inline-flex items-center justify-center"
        >
          Rent
        </Link>
        <button
          v-else
          class="flex-1 min-w-[140px] bg-gray-100 text-gray-400 py-3 rounded-lg font-semibold cursor-not-allowed"
          disabled
        >
          Rent
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  product: {
    type: Object,
    required: true
  }
});

const imageUrl = computed(() => props.product.image_url ?? props.product.image ?? props.product.thumbnail_url ?? null);
const fallbackIcon = computed(() => props.product.icon ?? '📦');
const categoryLabel = computed(() => props.product.categoryLabel ?? props.product.category ?? null);
const pricePerDay = computed(() => Number(props.product.price_per_day ?? props.product.price ?? props.product.daily_rate ?? 0));
const priceLabel = computed(() => new Intl.NumberFormat('en-PH', { minimumFractionDigits: 0 }).format(pricePerDay.value));
const featureList = computed(() => Array.isArray(props.product.features) ? props.product.features.slice(0, 4) : []);
const detailsUrl = computed(() => props.product.detailsUrl ?? null);
const rentUrl = computed(() => props.product.rentUrl ?? null);
</script>