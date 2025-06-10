<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'

defineProps({ auth: Object })
</script>

<template>
    <Head title="Blog" />
    <AppLayout :auth="auth">
        <div class="py-16 max-w-4xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Our Blog</h1>
            <p class="text-gray-600 dark:text-gray-300">Browse the latest articles, stories, and developer insights.</p>
        </div>
    </AppLayout>
</template>
