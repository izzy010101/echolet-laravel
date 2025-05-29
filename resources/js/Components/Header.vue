<script setup>
import { ref } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import { useDarkMode } from '@/Composables/useDarkMode'
import { Moon, Sun } from 'lucide-vue-next'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'

const { props } = usePage()
const user = props.auth?.user
const search = ref('')

const { isDark, toggleDarkMode } = useDarkMode()

function logout() {
  router.post(route('logout'))
}
</script>

<template>
  <header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-gray-200 dark:bg-gray-900/90 dark:border-gray-800 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
      
      <!-- Logo -->
      <Link href="/" class="text-xl font-bold text-gray-900 dark:text-white">
        Echolet
      </Link>

      <!-- Navigation -->
      <nav class="hidden md:flex items-center space-x-6">
        <Link href="/" class="text-gray-700 dark:text-gray-300 hover:text-black dark:hover:text-white transition">Home</Link>
        <Link href="/topics" class="text-gray-700 dark:text-gray-300 hover:text-black dark:hover:text-white transition">Topics</Link>
        <Link href="/about" class="text-gray-700 dark:text-gray-300 hover:text-black dark:hover:text-white transition">About</Link>
      </nav>

      <!-- Actions -->
      <div class="flex items-center space-x-3">
        
        <!-- Search bar -->
        <input
          type="text"
          v-model="search"
          placeholder="Search..."
          class="hidden sm:block px-3 py-1.5 rounded-md border border-gray-300 bg-white text-sm text-gray-800 placeholder:text-gray-400 dark:bg-gray-800 dark:text-white dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-primary"
        />

        <!-- Dark Mode Toggle -->
        <button @click="toggleDarkMode" class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition" aria-label="Toggle dark mode">
          <Sun v-if="isDark" class="w-5 h-5 text-yellow-400" />
          <Moon v-else class="w-5 h-5 text-gray-600 dark:text-gray-300" />
        </button>

        <!-- Subscribe Button -->
        <button
          class="px-3 py-1.5 text-sm font-medium bg-purple-600 text-white rounded-md hover:bg-purple-700 transition dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100"
        >
          Subscribe
        </button>

        <!-- Auth Buttons or Dropdown -->
        <div v-if="!user" class="flex items-center space-x-2">
          <Link href="/login" class="text-sm text-gray-700 dark:text-gray-300 hover:underline">Login</Link>
          <Link href="/register" class="text-sm text-gray-700 dark:text-gray-300 hover:underline">Register</Link>
        </div>

        <div v-else>
          <Dropdown class="">
            <template #trigger>
              <button
                class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-black dark:hover:text-white focus:outline-none"
              >
                <span>{{ user.name }}</span>
                <svg
                  class="ml-1 w-4 h-4"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7"
                  />
                </svg>
              </button>
            </template>

            <template #content>
              <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
              <DropdownLink :href="route('logout')" method="post" as="button">
                Log Out
              </DropdownLink>
            </template>
          </Dropdown>
        </div>

      </div>
    </div>
  </header>
</template>
