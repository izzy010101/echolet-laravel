<script setup>
import Header from '@/Components/Header.vue'
import Footer from '@/Components/Footer.vue'
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
    auth: Object,
    categories: Array,
})
</script>

<template>
    <div class="min-h-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">
        <Header :auth="auth" />
        <main>
            <slot />
        </main>
        <Footer :categories="props.categories" />
    </div>
</template>

