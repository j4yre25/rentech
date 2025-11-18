<template>
  <div class="flex gap-4">
    <div class="bg-yellow-400 text-gray-900 w-10 h-10 rounded-full flex items-center justify-center font-bold flex-shrink-0">
      {{ number }}
    </div>
    <div>
      <h4 class="text-xl font-bold text-gray-900 mb-2">{{ title }}</h4>
      <p class="text-gray-600">{{ description }}</p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  number: Number,
  title: String,
  description: String
})
</script>