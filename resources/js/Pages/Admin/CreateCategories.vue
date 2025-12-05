<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
  name: '',
  image: null,
  visible: true,
});

function submit() {
  form.post(route('categories.store'));
}

</script>


<template>
    <AppLayout title="Create Category">
  <div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Create Category</h1>

    <form @submit.prevent="submit">
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
        <input v-model="form.name" type="text" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
      </div>

      <div class="mb-4">
        <label for="image" class="block text-sm font-medium text-gray-700">Category Image</label>
        <input v-on:change="form.image" type="file" id="image" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
      </div>

      <div class="mb-4">
        <label for="visible" class="block text-sm font-medium text-gray-700">Visible on Site</label>
        <select v-model="form.visible" id="visible" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
          <option :value="true">Yes</option>
          <option :value="false">No</option>
        </select>
      </div>

      <PrimaryButton type="submit" class="btn btn-primary">Save Category</PrimaryButton>
    </form>
  </div>
  </AppLayout>
</template>

