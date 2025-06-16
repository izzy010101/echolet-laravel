<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const search = ref('')

function submitSearch() {
    if (search.value.trim()) {
        router.get('/search', { q: search.value })
    }
}
</script>

<template>
    <form @submit.prevent="submitSearch" class="w-full">
        <input
            v-model="search"
            type="text"
            placeholder="Search..."
            class="w-full px-3 py-1.5 rounded-md border border-gray-300 bg-white text-sm text-gray-800 placeholder:text-gray-400
             dark:bg-gray-800 dark:text-white dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-rose-500 transition"
        />
    </form>
</template>
