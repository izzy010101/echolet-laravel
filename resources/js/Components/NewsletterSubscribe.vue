<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    email: ''
})

function submit() {
    form.post(route('newsletter.subscribe'), {
        onSuccess: () => form.reset()
    })
}
</script>
<template>
    <div class="w-full max-w-md mx-auto p-6 rounded-lg bg-white shadow dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">
            Subscribe to our newsletter
        </h2>

        <form @submit.prevent="submit" class="flex flex-col md:flex-row items-stretch gap-3">
            <input
                v-model="form.email"
                type="email"
                placeholder="you@example.com"
                class="flex-1 px-4 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-black dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-500"
            />
            <button
                type="submit"
                class="px-6 py-2 rounded-md bg-pink-600 hover:bg-pink-700 text-white transition w-full md:w-auto"
            >
                Subscribe
            </button>
        </form>

        <p v-if="form.recentlySuccessful" class="mt-3 text-sm text-green-600 dark:text-green-400">
             Subscribed successfully!
        </p>
    </div>
</template>


