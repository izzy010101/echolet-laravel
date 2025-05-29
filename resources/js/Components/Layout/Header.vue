
<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const search = ref('')
const props = defineProps({
  auth: {
    type: Object,
    default: () => ({ user: null })
  }
})

function logout() {
  router.post('/logout')
}
</script>

<template>
  <header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
      <!-- Logo -->
      <Link href="/" class="text-xl font-bold text-gray-900">
        Echolet
      </Link>

      <!-- Navigation -->
      <nav class="hidden md:flex items-center space-x-6">
        <Link href="/" class="text-gray-700 hover:text-black transition">Home</Link>
        <Link href="/topics" class="text-gray-700 hover:text-black transition">Topics</Link>
        <Link href="/about" class="text-gray-700 hover:text-black transition">About</Link>
      </nav>

      <!-- Actions -->
      <div class="flex items-center space-x-3">
        <!-- Search bar -->
        <input
          type="text"
          v-model="search"
          placeholder="Search..."
          class="hidden sm:block px-3 py-1.5 rounded-md border border-gray-300 bg-white text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500"
        />

        <!-- Subscribe Button -->
        <button class="px-3 py-1.5 text-sm font-medium bg-gray-900 text-white rounded-md hover:bg-gray-800 transition">
          Subscribe
        </button>

        <!-- Auth Buttons -->
        <div v-if="auth && !auth.user" class="flex items-center space-x-2">
              <Link href="/login" class="text-sm text-gray-700 hover:underline">Login</Link>
              <Link href="/register" class="text-sm text-gray-700 hover:underline">Register</Link>
        </div>
        <div v-else class="flex items-center space-x-2">
          <Link href="/dashboard" class="text-sm text-gray-700 hover:text-black transition">
            {{ auth.user.name }}
          </Link>
          <form method="POST" @submit.prevent="logout">
            <button type="submit" class="text-sm text-gray-700 hover:text-black transition">
              Logout
            </button>
          </form>
        </div>
      </div>
    </div>
  </header>
</template>

