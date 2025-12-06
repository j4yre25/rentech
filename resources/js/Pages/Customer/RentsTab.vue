<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import NavBar from '@/Components/layout/NavBar.vue';
import Footer from '@/Components/layout/Footer.vue';

const props = defineProps({
  activeRents: {
    type: Array,
    default: () => []
  },
  rentHistory: {
    type: Array,
    default: () => []
  }
});

const activeTab = ref('active');

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

const formatPrice = (value) => {
  return Number(value ?? 0).toLocaleString('en-PH', { maximumFractionDigits: 0 });
};

const calculateDaysRemaining = (endDate) => {
  const end = new Date(endDate);
  const today = new Date();
  const diffTime = end - today;
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
  return diffDays;
};

const getStatusColor = (status) => {
  const colors = {
    'active': 'bg-green-100 text-green-800 border-green-200',
    'pending': 'bg-yellow-100 text-yellow-800 border-yellow-200',
    'completed': 'bg-blue-100 text-blue-800 border-blue-200',
    'cancelled': 'bg-red-100 text-red-800 border-red-200',
    'overdue': 'bg-orange-100 text-orange-800 border-orange-200'
  };
  return colors[status.toLowerCase()] || 'bg-gray-100 text-gray-800 border-gray-200';
};

const currentRents = computed(() => props.activeRents);
const pastRents = computed(() => props.rentHistory);
</script>

<template>
  <Head title="My Rents" />

  <div class="min-h-screen bg-gray-50 flex flex-col">
    <NavBar />

    <main class="flex-grow container mx-auto px-6 py-12">
      <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
          <h1 class="text-4xl font-bold text-gray-900 mb-2">My Rents</h1>
          <p class="text-gray-600">Monitor and manage your rented gadgets</p>
        </div>

        <!-- Tabs -->
        <div class="flex gap-4 mb-8 border-b border-gray-200">
          <button
            @click="activeTab = 'active'"
            :class="[
              'pb-4 px-6 font-semibold text-lg transition-all relative',
              activeTab === 'active'
                ? 'text-yellow-500'
                : 'text-gray-500 hover:text-gray-700'
            ]"
          >
            Active Rents
            <span
              v-if="currentRents.length > 0"
              class="ml-2 bg-yellow-400 text-white text-xs font-bold px-2 py-1 rounded-full"
            >
              {{ currentRents.length }}
            </span>
            <div
              v-if="activeTab === 'active'"
              class="absolute bottom-0 left-0 right-0 h-1 bg-yellow-400 rounded-t-lg"
            ></div>
          </button>
          <button
            @click="activeTab = 'history'"
            :class="[
              'pb-4 px-6 font-semibold text-lg transition-all relative',
              activeTab === 'history'
                ? 'text-yellow-500'
                : 'text-gray-500 hover:text-gray-700'
            ]"
          >
            History
            <div
              v-if="activeTab === 'history'"
              class="absolute bottom-0 left-0 right-0 h-1 bg-yellow-400 rounded-t-lg"
            ></div>
          </button>
        </div>

        <!-- Active Rents Tab -->
        <div v-show="activeTab === 'active'" class="space-y-6">
          <div v-if="currentRents.length === 0" class="text-center py-20 bg-white rounded-2xl shadow-sm">
            <div class="text-6xl mb-4">📦</div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">No Active Rents</h2>
            <p class="text-gray-600 mb-6">You don't have any active rentals at the moment.</p>
            <Link
              :href="route('gadgets.list')"
              class="inline-block bg-yellow-400 text-gray-900 px-8 py-3 rounded-lg font-semibold hover:bg-yellow-500 transition"
            >
              Browse Gadgets
            </Link>
          </div>

          <div
            v-for="rent in currentRents"
            :key="rent.id"
            class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-shadow overflow-hidden"
          >
            <div class="p-6">
              <div class="flex flex-col lg:flex-row gap-6">
                <!-- Product Image -->
                <div class="flex-shrink-0">
                  <div class="w-full lg:w-48 h-48 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden">
                    <img
                      v-if="rent.product_image"
                      :src="rent.product_image"
                      :alt="rent.product_name"
                      class="w-full h-full object-contain"
                    />
                    <span v-else class="text-6xl">📦</span>
                  </div>
                </div>

                <!-- Product Details -->
                <div class="flex-grow">
                  <div class="flex justify-between items-start mb-4">
                    <div>
                      <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ rent.product_name }}</h3>
                      <p class="text-gray-600">Order ID: #{{ rent.order_id }}</p>
                    </div>
                    <span
                      :class="['px-4 py-2 rounded-full text-sm font-semibold border', getStatusColor(rent.status)]"
                    >
                      {{ rent.status }}
                    </span>
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                      <p class="text-xs text-gray-600 mb-1">Start Date</p>
                      <p class="font-semibold text-gray-900">{{ formatDate(rent.start_date) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                      <p class="text-xs text-gray-600 mb-1">End Date</p>
                      <p class="font-semibold text-gray-900">{{ formatDate(rent.end_date) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                      <p class="text-xs text-gray-600 mb-1">Days Remaining</p>
                      <p class="font-semibold text-gray-900">{{ calculateDaysRemaining(rent.end_date) }} days</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                      <p class="text-xs text-gray-600 mb-1">Total Amount</p>
                      <p class="font-semibold text-yellow-500 text-lg">₱{{ formatPrice(rent.total_amount) }}</p>
                    </div>
                  </div>

                  <div class="flex flex-wrap gap-3">
                    <Link
                      :href="route('gadgets.show', rent.product_id)"
                      class="px-6 py-2 bg-gray-900 text-white rounded-lg font-medium hover:bg-black transition"
                    >
                      View Product
                    </Link>
                    <button
                      class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition"
                    >
                      Contact Rentor
                    </button>
                    <button
                      v-if="rent.status.toLowerCase() === 'active'"
                      class="px-6 py-2 border border-yellow-400 text-yellow-600 rounded-lg font-medium hover:bg-yellow-50 transition"
                    >
                      Extend Rental
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- History Tab -->
        <div v-show="activeTab === 'history'" class="space-y-6">
          <div v-if="pastRents.length === 0" class="text-center py-20 bg-white rounded-2xl shadow-sm">
            <div class="text-6xl mb-4">📜</div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">No Rental History</h2>
            <p class="text-gray-600">Your past rentals will appear here.</p>
          </div>

          <div
            v-for="rent in pastRents"
            :key="rent.id"
            class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow overflow-hidden"
          >
            <div class="p-6">
              <div class="flex flex-col lg:flex-row gap-6">
                <!-- Product Image -->
                <div class="flex-shrink-0">
                  <div class="w-full lg:w-40 h-40 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden">
                    <img
                      v-if="rent.product_image"
                      :src="rent.product_image"
                      :alt="rent.product_name"
                      class="w-full h-full object-contain"
                    />
                    <span v-else class="text-5xl">📦</span>
                  </div>
                </div>

                <!-- Product Details -->
                <div class="flex-grow">
                  <div class="flex justify-between items-start mb-3">
                    <div>
                      <h3 class="text-xl font-bold text-gray-900 mb-1">{{ rent.product_name }}</h3>
                      <p class="text-sm text-gray-600">Order ID: #{{ rent.order_id }}</p>
                    </div>
                    <span
                      :class="['px-3 py-1 rounded-full text-xs font-semibold border', getStatusColor(rent.status)]"
                    >
                      {{ rent.status }}
                    </span>
                  </div>

                  <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                    <div>
                      <p class="text-xs text-gray-600">Rental Period</p>
                      <p class="text-sm font-semibold text-gray-900">
                        {{ formatDate(rent.start_date) }} - {{ formatDate(rent.end_date) }}
                      </p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-600">Duration</p>
                      <p class="text-sm font-semibold text-gray-900">{{ rent.duration }} days</p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-600">Total Paid</p>
                      <p class="text-sm font-semibold text-yellow-500">₱{{ formatPrice(rent.total_amount) }}</p>
                    </div>
                    <div>
                      <p class="text-xs text-gray-600">Returned On</p>
                      <p class="text-sm font-semibold text-gray-900">{{ rent.returned_date ? formatDate(rent.returned_date) : 'N/A' }}</p>
                    </div>
                  </div>

                  <div class="flex flex-wrap gap-3">
                    <Link
                      :href="route('gadgets.show', rent.product_id)"
                      class="px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-black transition"
                    >
                      View Product
                    </Link>
                    <button
                      class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition"
                    >
                      Rent Again
                    </button>
                    <button
                      v-if="rent.status.toLowerCase() === 'completed' && !rent.review_submitted"
                      class="px-4 py-2 border border-yellow-400 text-yellow-600 rounded-lg text-sm font-medium hover:bg-yellow-50 transition"
                    >
                      Leave Review
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <Footer />
  </div>
</template>