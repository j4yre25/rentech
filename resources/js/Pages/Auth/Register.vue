<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const selectedRole = ref('rentee'); // simple string is enough

function continueToForm() {
  if (selectedRole.value === 'rentor') {
    router.get(route('register.rentor'));      // rentor form
  } else {
    router.get(route('register.rentee'));      // rentee form
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&display=swap');

h1 {
  font-family: 'Montserrat', Arial, sans-serif;
}
</style>

<template>
  <Head title="Create an Account" />

  <!-- Gradient background -->
  <div
    class="min-h-screen bg-gradient-to-b from-yellow-200 via-yellow-300 to-yellow-500 flex flex-col items-center justify-center px-4"
  >
    <!-- Logo -->
    <Link :href="route('home')" class="mb-8">
      <img src="/images/logo.png" alt="RenTech Logo" class="w-32 h-auto cursor-pointer" />
    </Link>

    <!-- Role selection card -->
    <div class="w-full max-w-md bg-white rounded-[4rem] shadow-xl p-8">
      <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 tracking-wide">Create an Account</h1>
        <p class="text-sm text-gray-600 mt-2">
          Have an Account?
          <Link :href="route('login')" class="text-blue-600 hover:underline">Sign In</Link>
        </p>
      </div>

      <p class="text-sm font-medium text-gray-700 mb-3">I want to register as:</p>

      <div class="space-y-3 mb-6">
        <!-- Rentee option -->
        <button
          type="button"
          class="w-full border rounded-xl px-4 py-3 text-left flex items-center justify-between transition
                 hover:border-gray-900"
          :class="selectedRole === 'rentee' ? 'border-gray-900 bg-gray-50' : 'border-gray-300 bg-white'"
          @click="selectedRole = 'rentee'"
        >
          <div>
            <div class="font-semibold text-gray-900">Rentee</div>
            <div class="text-xs text-gray-500">
              I want to rent gadgets from others.
            </div>
          </div>
          <span
            class="ml-4 inline-flex h-5 w-5 rounded-full border flex items-center justify-center text-xs"
            :class="
              selectedRole === 'rentee'
                ? 'border-gray-900 bg-gray-900 text-white'
                : 'border-gray-300 bg-white text-transparent'
            "
          >
            ●
          </span>
        </button>

        <!-- Rentor option -->
        <button
          type="button"
          class="w-full border rounded-xl px-4 py-3 text-left flex items-center justify-between transition
                 hover:border-gray-900"
          :class="selectedRole === 'rentor' ? 'border-gray-900 bg-gray-50' : 'border-gray-300 bg-white'"
          @click="selectedRole = 'rentor'"
        >
          <div>
            <div class="font-semibold text-gray-900">Rentor</div>
            <div class="text-xs text-gray-500">
              I want to list my gadgets for rent.
            </div>
          </div>
          <span
            class="ml-4 inline-flex h-5 w-5 rounded-full border flex items-center justify-center text-xs"
            :class="
              selectedRole === 'rentor'
                ? 'border-gray-900 bg-gray-900 text-white'
                : 'border-gray-300 bg-white text-transparent'
            "
          >
            ●
          </span>
        </button>
      </div>

      <button
        type="button"
        class="w-full rounded-md bg-[#1F2A44] text-white py-2 font-semibold hover:bg-[#152037] transition"
        @click="continueToForm"
      >
        Continue
      </button>
    </div>
  </div>
</template>
