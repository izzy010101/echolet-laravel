<script setup>
import Header from '@/Components/Header.vue'
import Footer from '@/Components/Footer.vue'
import {Head} from "@inertiajs/vue3";

const props = defineProps({
    auth: Object,
    categories: Array,
})
</script>

<template>
    <Head title="Categories Header" />
    <div class="min-h-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
        <Header :auth="auth" />

        <main class="max-w-6xl mx-auto px-4 py-12">
            <h1 class="text-3xl font-bold mb-8">All Categories</h1>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div
                    v-for="category in categories"
                    :key="category.id"
                    class="p-4 rounded-xl shadow hover:shadow-lg transition"
                >
                    {{ category.name }}
                </div>
            </div>
        </main>

        <Footer :categories="categories" />
    </div>
</template>
