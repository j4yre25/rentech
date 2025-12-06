<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: String,
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&display=swap');

h1 {
  font-family: 'Montserrat', sans-serif;
}
</style>

<template>
    <Head title="Verify Email" />

    <div class="min-h-screen bg-gradient-to-br from-yellow-200 via-yellow-300 to-yellow-400 flex flex-col items-center justify-center px-4 py-8">
        <!-- Logo -->
        <Link :href="route('home')" class="mb-8">
            <img src="/images/logo.png" alt="RenTech Logo" class="w-28 h-auto cursor-pointer hover:scale-105 transition-transform" />
        </Link>

        <!-- Card -->
        <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-10">
            <!-- Icon -->
            <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>

            <!-- Header -->
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Verify Your Email</h1>
                <p class="text-sm text-gray-600">
                    We've sent a verification link to your email address. Please click the link to verify your account and start renting!
                </p>
            </div>

            <!-- Success Message -->
            <div v-if="verificationLinkSent" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-medium text-green-800">
                        A new verification link has been sent to your email!
                    </p>
                </div>
            </div>

            <!-- Instructions -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-700 font-medium mb-2">📧 Check your email</p>
                <ul class="text-xs text-gray-600 space-y-1.5 ml-4 list-disc">
                    <li>Click the verification link we sent you</li>
                    <li>Check your spam folder if you don't see it</li>
                    <li>The link expires in 60 minutes</li>
                </ul>
            </div>

            <!-- Resend Form -->
            <form @submit.prevent="submit">
                <button
                    type="submit"
                    class="w-full rounded-lg bg-gradient-to-r from-gray-800 to-gray-900 text-white py-3 font-semibold hover:from-gray-900 hover:to-black shadow-md hover:shadow-lg transition disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="form.processing"
                >
                    <span v-if="!form.processing">Resend Verification Email</span>
                    <span v-else class="flex items-center justify-center gap-2">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Sending...
                    </span>
                </button>
            </form>

            <!-- Footer Links -->
            <div class="mt-6 pt-6 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                <Link
                    :href="route('login')"
                    class="text-sm text-gray-600 hover:text-gray-900 font-medium transition flex items-center gap-1"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Login
                </Link>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="text-sm text-red-600 hover:text-red-700 font-medium transition"
                >
                    Sign Out
                </Link>
            </div>
        </div>

        <!-- Help Text -->
        <p class="mt-6 text-sm text-gray-700 text-center max-w-md">
            Need help? Contact our support team at 
            <a href="mailto:support@rentech.com" class="font-medium text-gray-900 hover:underline">support@rentech.com</a>
        </p>
    </div>
</template>
