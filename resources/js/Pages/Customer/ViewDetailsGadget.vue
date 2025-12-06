<script setup>
import { ref, computed, watchEffect } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import NavBar from '@/Components/layout/NavBar.vue';
import Footer from '@/Components/layout/Footer.vue';

const props = defineProps({
  gadget: {
    type: Object,
    required: true
  },
  showRentForm: {
    type: Boolean,
    default: false
  }
});

const imageList = computed(() => {
  if (Array.isArray(props.gadget.images) && props.gadget.images.length) {
    return props.gadget.images;
  }

  if (props.gadget.image_url) {
    return [props.gadget.image_url];
  }

  return [
    `https://via.placeholder.com/600x400?text=${encodeURIComponent(props.gadget.name ?? 'Gadget')}`
  ];
});

const selectedIndex = ref(0);

watchEffect(() => {
  if (selectedIndex.value >= imageList.value.length) {
    selectedIndex.value = 0;
  }
});

const mainImage = computed(() => imageList.value[selectedIndex.value] ?? imageList.value[0]);

const specs = computed(() => {
  const source = props.gadget.specs ?? {};
  return [
    { icon: '⚙️', title: 'Processor', value: source.processor ?? 'Not specified' },
    { icon: '🔋', title: 'Battery Life', value: source.battery ?? 'Not specified' },
    { icon: '💾', title: 'Storage', value: source.storage ?? 'Not specified' },
    { icon: '🖥️', title: 'Display', value: source.display ?? 'Not specified' },
    { icon: '🔊', title: 'Audio', value: source.audio ?? 'Not specified' },
    { icon: '📶', title: 'Connectivity', value: source.connectivity ?? 'Not specified' },
  ];
});

const accessories = computed(() => {
  if (Array.isArray(props.gadget.included_items) && props.gadget.included_items.length) {
    return props.gadget.included_items;
  }

  if (Array.isArray(props.gadget.features) && props.gadget.features.length) {
    return props.gadget.features;
  }

  return ['No accessories listed'];
});

function formatPrice(value) {
  return Number(value ?? 0).toLocaleString('en-PH', { maximumFractionDigits: 0 });
}

const defaultStart = new Date();
const defaultEnd = new Date();
defaultEnd.setDate(defaultEnd.getDate() + 1);

const rentForm = useForm({
  start_date: defaultStart.toISOString().split('T')[0],
  end_date: defaultEnd.toISOString().split('T')[0],
  notes: ''
});

const submitRent = () => {
  rentForm.post(route('gadgets.rent.store', props.gadget.id), {
    preserveScroll: true,
  });
};

function rentNow() {
  if (props.showRentForm) {
    return;
  }

  router.visit(route('gadgets.rent', props.gadget.id));
}
</script>

<template>
  <div class="min-h-screen bg-gray-50 flex flex-col">
    <NavBar />
    
    <main class="flex-grow">
      <div class="mx-auto max-w-7xl px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
          <!-- LEFT SIDE: Product Info & Images -->
          <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-3">
              {{ gadget.name }}
            </h1>

            <div class="flex items-baseline gap-2 mb-8">
              <span class="text-5xl font-bold text-yellow-400">
                ₱{{ formatPrice(gadget.price_per_day) }}
              </span>
              <span class="text-gray-500 text-lg">/ day</span>
            </div>

            <!-- Main Image -->
            <div class="bg-white rounded-2xl p-8 mb-6 shadow-sm">
              <img
                :src="mainImage"
                alt="Main product image"
                class="w-full h-auto object-contain max-h-96"
              />
            </div>

            <!-- Thumbnail Gallery -->
            <div class="flex items-center gap-4 flex-wrap">
              <button
                v-for="(img, i) in imageList"
                :key="i"
                @click="selectedIndex = i"
                :class="[
                  'rounded-xl border-2 p-2 bg-white transition-all',
                  selectedIndex === i 
                    ? 'border-yellow-400 shadow-md' 
                    : 'border-gray-200 hover:border-gray-400'
                ]"
                :aria-label="`View image ${i + 1}`"
              >
                <img :src="img" class="h-20 w-28 object-contain" />
              </button>
            </div>
          </div>

          <!-- RIGHT SIDE: Technical Specs & Rent Button -->
          <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Technical Specification</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
              <div
                v-for="spec in specs"
                :key="spec.title"
                class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition"
              >
                <div class="flex items-center gap-3 mb-2">
                  <span class="text-2xl">{{ spec.icon }}</span>
                  <h3 class="font-semibold text-gray-900">{{ spec.title }}</h3>
                </div>
                <p class="text-gray-600 text-sm">{{ spec.value }}</p>
              </div>
            </div>

            <!-- Rent Button -->
            <button
              @click="rentNow"
              class="w-full bg-gray-900 text-white py-4 rounded-xl font-bold text-lg hover:bg-black transition shadow-lg mb-6"
            >
              Rent Now
            </button>

            <div
              v-if="showRentForm"
              class="rounded-xl border-2 border-yellow-400 bg-yellow-50 p-6 mb-8 space-y-5"
            >
              <h3 class="text-xl font-bold text-gray-900">
                Complete your rental request
              </h3>
              <form class="space-y-5" @submit.prevent="submitRent">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <label class="flex flex-col text-sm font-semibold text-gray-700">
                    Start Date
                    <input
                      type="date"
                      v-model="rentForm.start_date"
                      class="mt-2 rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"
                    />
                    <span v-if="rentForm.errors.start_date" class="text-xs text-red-500 mt-1">
                      {{ rentForm.errors.start_date }}
                    </span>
                  </label>
                  <label class="flex flex-col text-sm font-semibold text-gray-700">
                    End Date
                    <input
                      type="date"
                      v-model="rentForm.end_date"
                      class="mt-2 rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"
                    />
                    <span v-if="rentForm.errors.end_date" class="text-xs text-red-500 mt-1">
                      {{ rentForm.errors.end_date }}
                    </span>
                  </label>
                </div>

                <label class="flex flex-col text-sm font-semibold text-gray-700">
                  Notes to rentor (optional)
                  <textarea
                    rows="3"
                    v-model="rentForm.notes"
                    class="mt-2 rounded-lg border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"
                    placeholder="Share pickup details or special requests"
                  />
                  <span v-if="rentForm.errors.notes" class="text-xs text-red-500 mt-1">
                    {{ rentForm.errors.notes }}
                  </span>
                </label>

                <button
                  type="submit"
                  class="w-full bg-yellow-400 text-gray-900 font-semibold py-3 rounded-lg hover:bg-yellow-500 transition"
                  :disabled="rentForm.processing"
                >
                  {{ rentForm.processing ? 'Submitting...' : 'Submit Rental Request' }}
                </button>
              </form>
            </div>

            <!-- Included Accessories -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
              <h3 class="text-xl font-bold text-gray-900 mb-4">Included Accessories</h3>
              <ul class="space-y-3">
                <li 
                  v-for="(accessory, i) in accessories" 
                  :key="i" 
                  class="flex items-center gap-3 text-gray-800"
                >
                  <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-yellow-400 text-white text-sm font-bold">
                    ✓
                  </span>
                  <span>{{ accessory }}</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </main>

    <Footer />
  </div>
</template>
