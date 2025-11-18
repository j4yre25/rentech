<template>
  <div class="text-center">
    <div class="text-6xl mb-4">{{ icon }}</div>
    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ title }}</h3>
    <p class="text-gray-600">{{ description }}</p>
  </div>
</template>

<script setup>
defineProps({
  icon: String,
  title: String,
  description: String
})
</script>