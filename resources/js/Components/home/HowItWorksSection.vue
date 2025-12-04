<template>
  <section class="bg-gray-50 py-16 px-6">
    <div class="container mx-auto">
      <div class="grid md:grid-cols-2 gap-12 items-center">
        <img 
          src="https://images.unsplash.com/photo-1556740758-90de374c12ad?w=600&h=400&fit=crop" 
          alt="People using gadgets" 
          class="rounded-2xl shadow-xl w-full"
        >
        
        <div class="space-y-8">
          <ProcessStep 
            v-for="(step, index) in steps" 
            :key="index"
            :number="index + 1"
            :title="step.title"
            :description="step.description"
          />
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import ProcessStep from '../common/ProcessStep.vue'

const steps = [
  {
    title: 'Pick a gadget',
    description: 'Browse our wide selection of available gadgets'
  },
  {
    title: 'Set your schedule',
    description: 'Choose the dates that work best for you'
  },
  {
    title: 'Confirm your request',
    description: 'Review and submit your rental request'
  },
  {
    title: 'Enjoy your rental',
    description: 'Pick up your gadget and start using it!'
  }
]
</script>