<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'

defineProps({ auth: Object })
</script>

<template>
    <Head title="Contact" />
    <AppLayout :auth="auth">
        <div class="py-16 max-w-3xl mx-auto px-4">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-6 text-center">Contact Us</h1>
            <p class="text-gray-600 dark:text-gray-300 mb-8 text-center">Got questions? We'd love to hear from you.</p>
            <form class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Your Email</label>
                    <input type="email" class="w-full mt-1 px-4 py-2 rounded border dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Message</label>
                    <textarea rows="5" class="w-full mt-1 px-4 py-2 rounded border dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500"></textarea>
                </div>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-2 rounded-xl">Send Message</button>
            </form>
        </div>
    </AppLayout>
</template>
