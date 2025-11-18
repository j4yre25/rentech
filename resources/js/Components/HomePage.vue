<template>
  <div class="min-h-screen bg-white">
    <Navbar />
    <HeroSection @submit-rental="handleRentalSubmit" />
    <FeaturesSection />
    <ProductsSection />
    <Footer />
  </div>
</template>

<script setup>
import Navbar from './layout/NavBar.vue'
import HeroSection from './home/HeroSection.vue'
import FeaturesSection from './home/FeaturesSection.vue'
import ProductsSection from './home/ProductsSection.vue'
import Footer from './layout/Footer.vue'

const handleRentalSubmit = (formData) => {
  console.log('Rental form submitted:', formData)
  alert(`Rental Request:
Device: ${formData.deviceType}
Brand: ${formData.brand}
Duration: ${formData.duration} days
Date: ${formData.date}

(Backend integration coming soon!)`)
}
</script>