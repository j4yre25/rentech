<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const step = ref(1);

const form = useForm({
  // Step 1 – Basic Info
  name: '',
  email: '',
  password: '',
  password_confirmation: '',

  // Step 2 – Contact Info
  phone: '',
  address: '',

  // Step 3 – Verification (files are handled separately)
  government_id: null,
  selfie: null,

  // Step 4 – Payout Setup (optional)
  payout_type: '',
  gcash_number: '',
  bank_name: '',
  bank_account_name: '',
  bank_account_number: '',
});

const progressPercent = computed(() => (step.value / 4) * 100);

function handleFileChange(e, field) {
  const file = e.target.files[0] || null;
  form[field] = file;
}

function nextStep() {
  if (step.value === 1 && (!form.name || !form.email || !form.password || !form.password_confirmation)) {
    return;
  }
  if (step.value === 2 && (!form.phone || !form.address)) {
    return;
  }
  if (step.value === 3 && (!form.government_id || !form.selfie)) {
    return;
  }
  if (step.value < 4) step.value++;
}

function prevStep() {
  if (step.value > 1) step.value--;
}

const submit = () => {
  form.post(route('register.rentee'), {
    forceFormData: true,
    onFinish: () => form.reset('password', 'password_confirmation', 'government_id', 'selfie'),
  });
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&display=swap');

h1, h2 {
  font-family: 'Montserrat', sans-serif;
}

.file-input-zone {
  border: 2px dashed #d1d5db;
  border-radius: 0.75rem;
  padding: 1.5rem;
  text-align: center;
  transition: all 0.2s;
  cursor: pointer;
}

.file-input-zone:hover {
  border-color: #1f2937;
  background-color: #f9fafb;
}

.file-input-zone.active {
  border-color: #1f2937;
  background-color: #f3f4f6;
}

input[type="file"] {
  display: none;
}
</style>

<template>
  <Head title="Register as a Rentee" />

  <div class="min-h-screen bg-gradient-to-br from-yellow-200 via-yellow-300 to-yellow-400 flex flex-col items-center justify-center px-4 py-8">
    <!-- Logo -->
    <Link :href="route('home')" class="mb-6">
      <img src="/images/logo.png" alt="RenTech Logo" class="w-28 h-auto cursor-pointer hover:scale-105 transition-transform" />
    </Link>

    <!-- Card -->
    <div class="w-full max-w-lg bg-white rounded-3xl shadow-2xl p-10 relative">
      <!-- Back to chooser -->
      <Link
        :href="route('register')"
        class="absolute left-8 top-8 text-gray-500 hover:text-gray-900 flex items-center gap-2 text-sm font-medium transition group"
      >
        <span class="text-xl group-hover:-translate-x-1 transition-transform">&larr;</span>
        <span>Back</span>
      </Link>

      <!-- Header -->
      <div class="text-center mb-8 mt-6">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Register as a Rentee</h1>
        <p class="text-sm text-gray-600 mt-2">
          Rent premium gadgets without buying.
        </p>
        <p class="text-xs text-gray-500 mt-3">
          Already have an account?
          <Link :href="route('login')" class="text-blue-600 hover:underline font-medium">Sign In</Link>
        </p>
      </div>

      <!-- Progress Bar -->
      <div class="mb-8">
        <div class="flex justify-between items-center mb-2">
          <span class="text-xs font-semibold text-gray-700">Step {{ step }} of 4</span>
          <span class="text-xs font-medium text-gray-500">{{ Math.round(progressPercent) }}% Complete</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
          <div
            class="bg-gradient-to-r from-yellow-400 to-yellow-500 h-full rounded-full transition-all duration-500"
            :style="{ width: `${progressPercent}%` }"
          ></div>
        </div>
        <div class="flex justify-between mt-3 text-xs font-medium">
          <span :class="step >= 1 ? 'text-gray-900' : 'text-gray-400'">Basic</span>
          <span :class="step >= 2 ? 'text-gray-900' : 'text-gray-400'">Contact</span>
          <span :class="step >= 3 ? 'text-gray-900' : 'text-gray-400'">Verify</span>
          <span :class="step >= 4 ? 'text-gray-900' : 'text-gray-400'">Payout</span>
        </div>
      </div>

      <form @submit.prevent="submit">
        <!-- STEP 1 – BASIC INFO -->
        <div v-if="step === 1" class="space-y-5">
          <h2 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h2>

          <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
              Full Name <span class="text-red-500">*</span>
            </label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900 focus:ring-opacity-20 transition"
              placeholder="Juan Dela Cruz"
              required
              autofocus
            />
            <div v-if="form.errors.name" class="mt-1.5 text-sm text-red-600">
              {{ form.errors.name }}
            </div>
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
              Email Address <span class="text-red-500">*</span>
            </label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900 focus:ring-opacity-20 transition"
              placeholder="you@example.com"
              required
            />
            <div v-if="form.errors.email" class="mt-1.5 text-sm text-red-600">
              {{ form.errors.email }}
            </div>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
              Password <span class="text-red-500">*</span>
            </label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900 focus:ring-opacity-20 transition"
              placeholder="••••••••"
              required
            />
            <div v-if="form.errors.password" class="mt-1.5 text-sm text-red-600">
              {{ form.errors.password }}
            </div>
          </div>

          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
              Confirm Password <span class="text-red-500">*</span>
            </label>
            <input
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900 focus:ring-opacity-20 transition"
              placeholder="••••••••"
              required
            />
            <div v-if="form.errors.password_confirmation" class="mt-1.5 text-sm text-red-600">
              {{ form.errors.password_confirmation }}
            </div>
          </div>
        </div>

        <!-- STEP 2 – CONTACT INFO -->
        <div v-else-if="step === 2" class="space-y-5">
          <h2 class="text-lg font-semibold text-gray-800 mb-4">Contact Information</h2>

          <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
              Phone Number <span class="text-red-500">*</span>
            </label>
            <input
              id="phone"
              v-model="form.phone"
              type="tel"
              class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900 focus:ring-opacity-20 transition"
              placeholder="+63 912 345 6789"
              required
            />
            <div v-if="form.errors.phone" class="mt-1.5 text-sm text-red-600">
              {{ form.errors.phone }}
            </div>
          </div>

          <div>
            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
              Complete Address <span class="text-red-500">*</span>
            </label>
            <textarea
              id="address"
              v-model="form.address"
              rows="4"
              class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900 focus:ring-opacity-20 transition resize-none"
              placeholder="Street, Barangay, City, Province"
              required
            ></textarea>
            <div v-if="form.errors.address" class="mt-1.5 text-sm text-red-600">
              {{ form.errors.address }}
            </div>
          </div>
        </div>

        <!-- STEP 3 – VERIFICATION -->
        <div v-else-if="step === 3" class="space-y-5">
          <h2 class="text-lg font-semibold text-gray-800 mb-4"> Identity Verification</h2>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Government ID <span class="text-red-500">*</span>
            </label>
            <label
              for="government_id"
              class="file-input-zone"
              :class="{ active: form.government_id }"
            >
              <div class="flex flex-col items-center gap-2">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                <div class="text-sm">
                  <span class="font-semibold text-gray-700">
                    {{ form.government_id ? form.government_id.name : 'Click to upload' }}
                  </span>
                  <span v-if="!form.government_id" class="text-gray-500"> or drag and drop</span>
                </div>
                <p class="text-xs text-gray-500">PNG, JPG or PDF up to 10MB</p>
              </div>
              <input
                id="government_id"
                type="file"
                accept="image/*,application/pdf"
                @change="e => handleFileChange(e, 'government_id')"
                required
              />
            </label>
            <div v-if="form.errors.government_id" class="mt-1.5 text-sm text-red-600">
              {{ form.errors.government_id }}
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Selfie with ID <span class="text-red-500">*</span>
            </label>
            <label
              for="selfie"
              class="file-input-zone"
              :class="{ active: form.selfie }"
            >
              <div class="flex flex-col items-center gap-2">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <div class="text-sm">
                  <span class="font-semibold text-gray-700">
                    {{ form.selfie ? form.selfie.name : 'Click to upload selfie' }}
                  </span>
                  <span v-if="!form.selfie" class="text-gray-500"> or drag and drop</span>
                </div>
                <p class="text-xs text-gray-500">Hold your ID beside your face</p>
              </div>
              <input
                id="selfie"
                type="file"
                accept="image/*"
                @change="e => handleFileChange(e, 'selfie')"
                required
              />
            </label>
            <div v-if="form.errors.selfie" class="mt-1.5 text-sm text-red-600">
              {{ form.errors.selfie }}
            </div>
          </div>
        </div>

        <!-- STEP 4 – PAYOUT SETUP -->
        <div v-else-if="step === 4" class="space-y-5">
          <h2 class="text-lg font-semibold text-gray-800 mb-2">Payout Setup</h2>
          <p class="text-sm text-gray-500 mb-4">
            Optional: Add your payout details now or complete later in your profile.
          </p>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Method</label>
            <select
              v-model="form.payout_type"
              class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-gray-900 focus:ring-2 focus:ring-gray-900 focus:ring-opacity-20 transition"
            >
              <option value="">Skip for now</option>
              <option value="gcash">GCash</option>
              <option value="bank">Bank Transfer</option>
            </select>
          </div>

          <!-- GCash -->
          <div v-if="form.payout_type === 'gcash'">
            <label for="gcash_number" class="block text-sm font-medium text-gray-700 mb-1">GCash Number</label>
            <input
              id="gcash_number"
              v-model="form.gcash_number"
              type="text"
              class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900 focus:ring-opacity-20 transition"
              placeholder="09XXXXXXXXX"
            />
          </div>

          <!-- Bank -->
          <div v-if="form.payout_type === 'bank'" class="space-y-4">
            <div>
              <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-1">Bank Name</label>
              <input
                id="bank_name"
                v-model="form.bank_name"
                type="text"
                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900 focus:ring-opacity-20 transition"
                placeholder="e.g., BDO, BPI, Metrobank"
              />
            </div>
            <div>
              <label for="bank_account_name" class="block text-sm font-medium text-gray-700 mb-1">Account Name</label>
              <input
                id="bank_account_name"
                v-model="form.bank_account_name"
                type="text"
                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900 focus:ring-opacity-20 transition"
                placeholder="Name on the account"
              />
            </div>
            <div>
              <label for="bank_account_number" class="block text-sm font-medium text-gray-700 mb-1">Account Number</label>
              <input
                id="bank_account_number"
                v-model="form.bank_account_number"
                type="text"
                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:ring-2 focus:ring-gray-900 focus:ring-opacity-20 transition"
                placeholder="Account number"
              />
            </div>
          </div>
        </div>

        <!-- Navigation -->
        <div class="mt-8 flex justify-between items-center">
          <button
            v-if="step > 1"
            type="button"
            class="px-6 py-2.5 rounded-lg border-2 border-gray-300 text-gray-700 font-medium hover:bg-gray-50 hover:border-gray-400 transition"
            @click="prevStep"
          >
            ← Previous
          </button>
          <span v-else></span>

          <button
            v-if="step < 4"
            type="button"
            class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-gray-800 to-gray-900 text-white font-semibold hover:from-gray-900 hover:to-black shadow-md hover:shadow-lg transition"
            @click="nextStep"
          >
            Next →
          </button>

          <button
            v-else
            type="submit"
            class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 font-bold hover:from-yellow-500 hover:to-yellow-600 shadow-md hover:shadow-lg transition disabled:opacity-50"
            :disabled="form.processing"
          >
            ✓ Create Account
          </button>
        </div>
      </form>
    </div>
  </div>
</template>