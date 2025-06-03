<!--newsletterwelcome.vue-->
<script setup>
import {useForm } from '@inertiajs/vue3'
import { ref } from 'vue'


const form = useForm({
    email: ''
})

const alreadySubscribedMessage = ref('')

function submit() {
    if (localStorage.getItem('newsletter_subscribed') === form.email) {
        alreadySubscribedMessage.value = 'You have already subscribed.'
        return
    }

    form.post(route('newsletter.subscribe'), {
        onSuccess: () => {
            localStorage.setItem('newsletter_subscribed', form.email)
            form.reset()
            alreadySubscribedMessage.value = '' // clear any old error
        }
    })
}

</script>
<template>
    <div class="w-full max-w-lg mx-auto p-6 rounded-lg bg-white shadow dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">
            Subscribe to our newsletter
        </h2>

        <form @submit.prevent="submit" class="flex flex-col gap-3">
            <input
                v-model="form.email"
                type="email"
                placeholder="you@example.com"
                class="w-full px-4 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-black dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-500"
            />

            <button
                type="submit"
                :disabled="form.processing"
                class="px-4 py-2 rounded bg-pink-600 text-white hover:bg-pink-700"
            >
                Subscribe
            </button>

            <p v-if="form.recentlySuccessful && !alreadySubscribedMessage" class="text-sm text-green-600 dark:text-green-400">
                Subscribed successfully!
            </p>

        </form>

    </div>
</template>


