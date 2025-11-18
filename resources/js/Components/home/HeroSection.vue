<template>
  <section id="home" class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-b-[50px] px-6 py-16">
    <div class="container mx-auto">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <!-- Hero Content -->
        <HeroContent />
        
        <!-- Rental Form -->
        <RentalForm @submit="handleSubmit" />
      </div>
    </div>
  </section>
</template>

<script setup>
import HeroContent from './HeroContent.vue'
import RentalForm from '../forms/RentalForm.vue'

const emit = defineEmits(['submit-rental'])

const handleSubmit = (formData) => {
  emit('submit-rental', formData)
}
</script>