<template>
  <div class="bg-white rounded-2xl shadow-2xl p-8">
    <h3 class="text-2xl font-bold text-gray-900 mb-6">Rent your Gadget!</h3>
    <form @submit.prevent="submitForm">
      <FormSelect 
        v-model="formData.deviceType"
        label="Select Device Type"
        :options="deviceTypes"
        placeholder="Select a device"
      />
      
      <FormSelect 
        v-model="formData.brand"
        label="Choose your brand"
        :options="brands"
        placeholder="Select brand"
      />
      
      <FormInput 
        v-model.number="formData.duration"
        label="Duration (in days)"
        type="number"
        placeholder="7"
        :min="1"
      />
      
      <FormInput 
        v-model="formData.date"
        label="Select date"
        type="date"
      />

      <button 
        type="submit"
        class="w-full bg-gray-900 text-white py-3 rounded-lg font-semibold text-lg hover:bg-black transition"
      >
        Submit
      </button>
    </form>
  </div>
</template>

<script setup>
import { reactive } from 'vue'
import FormSelect from './FormSelect.vue'
import FormInput from './FormInput.vue'

const emit = defineEmits(['submit'])

const formData = reactive({
  deviceType: '',
  brand: '',
  duration: null,
  date: ''
})

const deviceTypes = [
  { value: 'laptop', label: 'Laptop' },
  { value: 'camera', label: 'Camera' },
  { value: 'phone', label: 'Phone' },
  { value: 'headphones', label: 'Headphones' },
  { value: 'tablet', label: 'Tablet' }
]

const brands = [
  { value: 'apple', label: 'Apple' },
  { value: 'samsung', label: 'Samsung' },
  { value: 'canon', label: 'Canon' },
  { value: 'sony', label: 'Sony' },
  { value: 'lenovo', label: 'Lenovo' }
]

const submitForm = () => {
  emit('submit', { ...formData })
}
</script>