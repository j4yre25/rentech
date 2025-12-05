<template>
  <header class="sticky top-0 z-50 bg-white shadow-md">
    <nav class="container mx-auto px-6 py-4">
      <div class="flex items-center justify-between">
        <!-- Logo -->
        <Logo />

        <!-- Navigation Links -->
        <ul class="hidden md:flex items-center gap-8">
          <li v-for="link in navLinks" :key="link.name">
            <a :href="link.href" class="text-gray-700 hover:text-yellow-500 font-medium transition">
              {{ link.name }}
            </a>
          </li>
        </ul>

        <!-- Actions -->
        <div class="flex items-center gap-4">
          <template v-if="!userRole">
            <a :href="route('login')" class="text-gray-700 font-medium hover:text-yellow-500 transition">
              Log In
            </a>
            <a :href="route('register')"
              class="bg-gray-900 text-white px-6 py-2 rounded-full font-medium hover:bg-black transition">
              Sign Up
            </a>
          </template>

          <template v-else>
            <Dropdown align="right" width="48">
              <template #trigger>
                <button
                  class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                  <img class="size-8 rounded-full object-cover" :src="page.props.auth.user.profile_photo_url"
                    :alt="page.props.auth.user.name">
                </button>
              </template>

              <template #content>
                <DropdownLink :href="route('profile.show')">
                  Profile
                </DropdownLink>
                <div class="border-t border-gray-200" />
                <form @submit.prevent="logout">
                  <DropdownLink as="button" @click="logout">
                    Log Out
                  </DropdownLink>
                </form>
              </template>
            </Dropdown>
          </template>
        </div>
      </div>
    </nav>
  </header>
</template>

<script setup>
import Logo from './Logo.vue';
import { usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Inertia } from '@inertiajs/inertia';


const navLinks = [
  { name: 'Home', href: '#home' },
  { name: 'Gadgets', href: '#gadgets' },
  { name: 'Details', href: '#details' },
  { name: 'About Us', href: '#about' },
  { name: 'Contact Us', href: '#contact' }
];

const page = usePage();
const userRole = page.props.auth?.role;

function logout() {
    Inertia.post(route('logout'), {}, {
        onSuccess: () => {
            console.log('Logged out successfully');
        },
        onError: (error) => {
            console.error('Logout failed:', error);
        },
    });
}
</script>