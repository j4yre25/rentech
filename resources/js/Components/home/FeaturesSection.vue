<template>
  <section class="py-16 px-6">
    <div class="container mx-auto">
      <div class="grid md:grid-cols-3 gap-12">
        <FeatureCard 
          v-for="feature in features" 
          :key="feature.title"
          :icon="feature.icon"
          :title="feature.title"
          :description="feature.description"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import FeatureCard from '../common/FeatureCard.vue'

const features = [
  {
    icon: '📦',
    title: 'Availability',
    description: "Choose from a wide range of gadgets, available for rent and ready for instant rental."
  },
  {
    icon: '💻',
    title: 'Comfort',
    description: 'Convenient and fast rennnting process'
  },
  {
    icon: '💰',
    title: 'Savings',
    description: 'Enjoy flexible rental plans that fit your budget. No hidden fees, No hassle'
  }
]
</script>