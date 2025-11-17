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
    description: "Countless tech from the world's leading brands and products for everyone"
  },
  {
    icon: '💻',
    title: 'Comfort',
    description: 'Experience our fast rental process'
  },
  {
    icon: '💰',
    title: 'Savings',
    description: 'Enjoy more features from the device without having to pay for it entirely'
  }
]
</script>