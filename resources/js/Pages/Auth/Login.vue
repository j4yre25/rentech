<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Logo from '@/Components/layout/Logo.vue'; // Import your logo component

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.transform(data => ({
    ...data,
    remember: form.remember ? 'on' : '',
  })).post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&display=swap');

h1 {
  font-family: 'Montserrat', Arial, sans-serif;
}
</style>

<template>
  <Head title="Log in" />

  <!-- Gradient background -->
  <div class="min-h-screen bg-gradient-to-b from-yellow-200 via-yellow-300 to-yellow-500 flex flex-col items-center justify-center px-4">
    <!-- Logo above the card -->
    <Link :href="route('home')">
      <img src="/images/logo.png" alt="RenTech Logo" class="w-32 h-auto cursor-pointer" />
    </Link>

    <!-- Card -->
    <div class="w-full max-w-md bg-white rounded-[4rem] shadow-xl p-8">
      <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 font-[Montserrat] tracking-wide">Log In</h1>
        <p class="text-sm text-gray-600 mt-2">
          New to Our Product?
          <Link :href="route('register')" class="text-blue-600 hover:underline">Create an Account</Link>
        </p>
      </div>

      <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
      </div>

      <form @submit.prevent="submit">
        <!-- Email -->
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-gray-900"
            placeholder="Enter Email Address"
            required
            autofocus
            autocomplete="username"
          />
          <div v-if="form.errors.email" class="mt-2 text-sm text-red-600">{{ form.errors.email }}</div>
        </div>

        <!-- Password -->
        <div class="mb-6">
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-gray-900"
            placeholder="Enter Password"
            required
            autocomplete="current-password"
          />
          <div v-if="form.errors.password" class="mt-2 text-sm text-red-600">{{ form.errors.password }}</div>
        </div>

        <!-- Submit -->
        <button
          type="submit"
          class="mt-6 w-full rounded-md bg-[#1F2A44] text-white py-2 font-semibold hover:bg-[#152037] transition disabled:opacity-50"
          :disabled="form.processing"
        >
          Log in
        </button>
      </form>
    </div>
  </div>
</template>
