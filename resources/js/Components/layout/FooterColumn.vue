<template>
  <div>
    <h4 class="text-yellow-400 font-bold text-lg mb-4">{{ title }}</h4>
    <ul class="space-y-2">
      <li v-for="link in links" :key="link.name">
        <a :href="link.href" class="text-black-400 hover:text-yellow-400 transition">
          {{ link.name }}
        </a>
      </li>
    </ul>
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    required: true
  },
  links: {
    type: Array,
    required: true
  }
})
</script>