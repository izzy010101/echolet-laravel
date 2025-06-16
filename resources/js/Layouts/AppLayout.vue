<script setup>
import Header from '@/Components/Header.vue'
import Footer from '@/Components/Footer.vue'
import { usePage } from '@inertiajs/vue3'

const { props, url } = usePage()
</script>

<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
        <Header :auth="props.auth" :current-url="url" />

        <main>
            <slot />
        </main>

        <Footer :categories="props.footerCategories || []" />
    </div>
</template>
