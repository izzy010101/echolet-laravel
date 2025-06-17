<script setup>
import Header from '@/Components/Header.vue'
import Footer from '@/Components/Footer.vue'
import { usePage } from '@inertiajs/vue3'

const { url } = usePage()
defineProps({
    auth: Object,
    footerCategories: Array
})
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-rose-50 via-pink-50 to-purple-50 dark:from-gray-900 dark:to-gray-950 flex flex-col text-gray-900 dark:text-gray-100 transition-colors duration-300">
        <Header :auth="auth" :current-url="url" />

        <main>
            <slot />
        </main>

        <Footer :categories="footerCategories || []" />
    </div>
</template>
