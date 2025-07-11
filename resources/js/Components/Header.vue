<script setup>
import { ref } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import { useDarkMode } from '@/Composables/useDarkMode'
import { Moon, Sun } from 'lucide-vue-next'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
import SearchBar from '@/Components/SearchBar.vue'

const pageProps = usePage().props
const user = pageProps.auth?.user ?? null
const routeName = usePage().component // e.g., 'Contact', 'Posts/Show', etc.

const search = ref('')
const mobileMenuOpen = ref(false)
const { isDark, toggleDarkMode } = useDarkMode()

function logout() {
    router.post(route('logout'), {}, {
        onSuccess: () => {
            window.location.href = route('home')
        }
    })
}
</script>

<template>
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-gray-200 dark:bg-gray-900/90 dark:border-gray-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <!-- Logo -->
            <Link href="/" class="text-xl font-bold text-gray-900 dark:text-white">Echolet</Link>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-6">
                <Link href="/" class="text-gray-700 dark:text-gray-300 hover:text-pink-500 dark:hover:text-pink-400 transition">Home</Link>
                <Link href="/blog" class="text-gray-700 dark:text-gray-300 hover:text-pink-500 dark:hover:text-pink-400 transition">Blog</Link>
                <Link :href="route('categories.index')" class="text-gray-700 dark:text-gray-300 hover:text-pink-500 dark:hover:text-pink-400 transition">Categories</Link>
                <Link href="/contact" class="text-gray-700 dark:text-gray-300 hover:text-pink-500 dark:hover:text-pink-400 transition">Contact</Link>
                <Link v-if="user" href="/dashboard" class="text-gray-700 dark:text-gray-300 hover:text-pink-500 dark:hover:text-pink-400 transition">Dashboard</Link>
            </nav>

            <!-- Mobile Toggle -->
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-pink-500">
                    <svg v-if="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Desktop Actions -->
            <div class="hidden md:flex items-center space-x-3">
                <SearchBar v-if="!['Contact', 'Posts/Show'].includes(routeName)" />

                <button @click="toggleDarkMode" class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition" aria-label="Toggle dark mode">
                    <Sun v-if="isDark" class="w-5 h-5 text-yellow-400" />
                    <Moon v-else class="w-5 h-5 text-gray-600 dark:text-gray-300" />
                </button>

                <template v-if="!user">
                    <Link href="/login" class="text-sm text-gray-700 dark:text-gray-300 hover:underline">Login</Link>
                    <Link href="/register" class="text-sm text-gray-700 dark:text-gray-300 hover:underline">Register</Link>
                </template>

                <template v-else>
                    <Dropdown>
                        <template #trigger>
                            <button class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-black dark:hover:text-white focus:outline-none">
                                <span>{{ user.name }}</span>
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </template>
                        <template #content>
                            <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                            <button @click="logout" class="block w-full px-4 py-2 text-start text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-800 transition">Log Out</button>
                        </template>
                    </Dropdown>
                </template>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div v-if="mobileMenuOpen" class="md:hidden px-4 pb-4 space-y-2 bg-white dark:bg-gray-900 shadow">
            <div class="flex justify-end">
                <button @click="toggleDarkMode" class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <Sun v-if="isDark" class="w-5 h-5 text-yellow-400"/>
                    <Moon v-else class="w-5 h-5 text-gray-600 dark:text-gray-300"/>
                </button>
            </div>

            <Link href="/" class="block text-gray-700 dark:text-gray-300 hover:text-pink-500 dark:hover:text-pink-400">
                Home
            </Link>
            <Link href="/blog"
                  class="block text-gray-700 dark:text-gray-300 hover:text-pink-500 dark:hover:text-pink-400">Blog
            </Link>
            <Link href="/categories"
                  class="block text-gray-700 dark:text-gray-300 hover:text-pink-500 dark:hover:text-pink-400">Categories
            </Link>
            <Link href="/contact"
                  class="block text-gray-700 dark:text-gray-300 hover:text-pink-500 dark:hover:text-pink-400">Contact
            </Link>
            <Link v-if="user" href="/dashboard"
                  class="block text-gray-700 dark:text-gray-300 hover:text-pink-500 dark:hover:text-pink-400">Dashboard
            </Link>

            <template v-if="!user">
                <Link href="/login"
                      class="block text-gray-700 dark:text-gray-300 hover:text-pink-500 dark:hover:text-pink-400">Login
                </Link>
                <Link href="/register"
                      class="block text-gray-700 dark:text-gray-300 hover:text-pink-500 dark:hover:text-pink-400">
                    Register
                </Link>
            </template>

            <template v-else>
                <Link :href="route('profile.edit')"
                      class="block text-gray-700 dark:text-gray-300 hover:text-pink-500 dark:hover:text-pink-400">
                    Profile
                </Link>
                <button @click="logout"
                        class="block w-full text-left text-gray-700 dark:text-gray-300 hover:text-pink-500 dark:hover:text-pink-400">
                    Logout
                </button>
            </template>
        </div>
    </header>
</template>
