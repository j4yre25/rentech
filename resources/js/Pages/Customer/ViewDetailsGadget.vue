        <script setup>
        import { ref, computed } from 'vue'
        import { router } from '@inertiajs/vue3'
        
        const props = defineProps({
          gadget: {
            type: Object,
            default: () => ({
              name: 'Apple MacBook Air',
              pricePerDay: 350,
              images: [
                '/images/macbook-air/main.jpg',
                '/images/macbook-air/angle-1.jpg',
                '/images/macbook-air/angle-2.jpg',
              ],
              specs: {
                processor: 'Apple M2 Chip',
                battery: 'Up To 18 Hours',
                storage: '512GB SSD',
                display: '13.6-Inch Liquid Retina',
                audio: 'Spatial Audio Support',
                connectivity: 'WiFi 6 + Bluetooth 5.3',
              },
              id: 1,
            }),
          },
        })
        
        const selectedIndex = ref(0)
        const mainImage = computed(() => props.gadget.images?.[selectedIndex.value] ?? '')
        const accessories = computed(() => [
          'Charger',
          'Carry Case',
          'Type-C Cable',
        ])
        
        function formatPrice(val) {
          try {
            return Number(val).toLocaleString('en-PH', { maximumFractionDigits: 0 })
          } catch {
            return val
          }
        }
        
        function rentNow() {
          // Adjust to your route name and params
          router.visit(`/rent/${props.gadget.id}`)
        }
        </script>
        
        <!-- Lightweight spec card component -->
        <script>
        export default {
          components: {
            SpecCard: {
              props: {
                icon: String,
                title: String,
                value: String,
              },
              template: `
                <div class="rounded-2xl border border-gray-200 bg-white p-4">
                  <div class="flex items-center gap-3 mb-2">
                    <span class="text-xl">{{ icon }}</span>
                    <span class="font-semibold text-black">{{ title }}</span>
                  </div>
                  <div class="text-gray-600">{{ value }}</div>
                </div>
              `,
            },
          },
        }
        </script>
        
        <style scoped>
        /* Keep spacing and clean cards similar to the mock */
        </style>
<template>
  <div class="min-h-screen bg-white">
    <!-- Page container -->
    <div class="mx-auto max-w-7xl px-6 lg:px-8 py-10">
      <!-- Top section: Title, price, gallery -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        <!-- Left: Title + price + gallery -->
        <div class="lg:col-span-7">
          <h1 class="text-4xl sm:text-5xl font-bold text-black mb-4">
            {{ gadget.name || 'Apple MacBook Air' }}
          </h1>

          <div class="flex items-baseline gap-2 mb-6">
            <span class="text-4xl sm:text-5xl font-bold text-yellow-400">
              ₱{{ formatPrice(gadget.pricePerDay ?? 350) }}
            </span>
            <span class="text-gray-500 text-lg">/ day</span>
          </div>

          <!-- Main image -->
          <div class="bg-white rounded-xl overflow-hidden mb-6">
            <img
              :src="mainImage"
              alt="Main image"
              class="w-full h-auto object-contain"
            />
          </div>

          <!-- Thumbnails -->
          <div class="flex items-center gap-4">
            <button
              v-for="(img, i) in gadget.images"
              :key="i"
              class="rounded-xl border border-gray-200 hover:border-black transition p-2 bg-white"
              @click="selectedIndex = i"
              :aria-label="`Image ${i + 1}`"
            >
              <img :src="img" class="h-16 w-24 object-contain" />
            </button>
          </div>
        </div>

        <!-- Right: Specs cards + Rent Now -->
        <div class="lg:col-span-5">
          <h2 class="text-xl font-semibold text-black mb-4">Technical Specification</h2>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <SpecCard icon="⚙️" title="Processor" :value="gadget.specs.processor || 'Apple M2 Chip'" />
            <SpecCard icon="🔋" title="Battery Life" :value="gadget.specs.battery || 'Up To 18 Hours'" />
            <SpecCard icon="💾" title="Storage" :value="gadget.specs.storage || '512GB SSD'" />
            <SpecCard icon="🖥️" title="Display" :value="gadget.specs.display || '13.6-Inch Liquid Retina'" />
            <SpecCard icon="🔊" title="Audio" :value="gadget.specs.audio || 'Spatial Audio Support'" />
            <SpecCard icon="📶" title="Connectivity" :value="gadget.specs.connectivity || 'WiFi 6 + Bluetooth 5.3'" />
          </div>

          <div class="mt-6">
            <button
              class="w-full sm:w-auto px-6 py-3 rounded-xl bg-black text-white hover:bg-gray-900 transition"
              @click="rentNow"
            >
              Rent Now
            </button>
          </div>
        </div>
      </div>

      <!-- Accessories -->
      <div class="mt-10">
        <h3 class="text-xl font-semibold text-black mb-4">Included Accessories</h3>
        <ul class="space-y-3">
          <li v-for="(acc, i) in accessories" :key="i" class="flex items-center gap-3 text-gray-800">
            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-yellow-400 text-white font-bold">✓</span>
            <span>{{ acc }}</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
