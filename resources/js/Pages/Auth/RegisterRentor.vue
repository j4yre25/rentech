<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register.rentor'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
  <Head title="Create an Account" />

  <!-- Gradient background -->
  <div class="min-h-screen bg-gradient-to-b from-yellow-200 via-yellow-300 to-yellow-500 flex flex-col items-center justify-center px-4">
    <!-- Optional logo (same as Login.vue) -->
    <Link :href="route('home')" >
      <img src="/images/logo.png" alt="RenTech Logo" class="w-32 h-auto cursor-pointer" />
    </Link>

    <!-- Card -->
    <div class="w-full max-w-md bg-white rounded-[4rem] shadow-xl p-8">
      <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 tracking-wide">Create an Account</h1>
        <p class="text-sm text-gray-600 mt-2">
          Have an Account?
          <Link :href="route('login')" class="text-blue-600 hover:underline">Sign In</Link>
        </p>
      </div>

      <form @submit.prevent="submit">
        <!-- Name -->
        <div class="mb-4">
          <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-gray-900"
            placeholder="Enter Full Name"
            required
            autofocus
            autocomplete="name"
          />
          <div v-if="form.errors.name" class="mt-2 text-sm text-red-600">{{ form.errors.name }}</div>
        </div>

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
            autocomplete="username"
          />
          <div v-if="form.errors.email" class="mt-2 text-sm text-red-600">{{ form.errors.email }}</div>
        </div>

        <!-- Password -->
        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-gray-900"
            placeholder="Create Password"
            required
            autocomplete="new-password"
          />
          <div v-if="form.errors.password" class="mt-2 text-sm text-red-600">{{ form.errors.password }}</div>
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
          <input
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
            class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-gray-900"
            placeholder="Confirm Password"
            required
            autocomplete="new-password"
          />
          <div v-if="form.errors.password_confirmation" class="mt-2 text-sm text-red-600">{{ form.errors.password_confirmation }}</div>
        </div>

        

        <!-- Submit -->
        <button
          type="submit"
          class="w-full rounded-md bg-[#1F2A44] text-white py-2 font-semibold hover:bg-[#152037] transition disabled:opacity-50"
          :disabled="form.processing"
        >
          Create Account
        </button>
      </form>
    </div>
  </div>
</template>
