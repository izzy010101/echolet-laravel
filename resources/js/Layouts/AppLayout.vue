<script setup>
import Header from '@/Components/Header.vue'
import FooterComponent from '@/Components/Footer.vue'

const props = defineProps({
  auth: Object
})
</script>

<template>
    <div class="min-h-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">
        <Header :auth="auth" />
        <main>
            <slot />
        </main>
        <FooterComponent />
    </div>
</template>

