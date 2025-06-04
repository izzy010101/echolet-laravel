<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    email: ''
});

const message = ref('');
const messageType = ref(''); // success or warning

function submit() {
    // Basic email format validation
    const emailRegex = /^\S+@\S+\.\S+$/;
    if (!form.email.match(emailRegex)) {
        message.value = 'Please enter a valid email address.';
        messageType.value = 'warning';
        clearMessageAfterDelay();
        return;
    }

    // LocalStorage check
    if (localStorage.getItem('newsletter_subscribed') === form.email) {
        message.value = 'You have already subscribed.';
        messageType.value = 'warning';
        clearMessageAfterDelay();
        return;
    }

    // Inertia POST
    form.post(route('newsletter.subscribe'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            localStorage.setItem('newsletter_subscribed', form.email);
            form.reset();
            message.value = 'Subscribed successfully!';
            messageType.value = 'success';
            clearMessageAfterDelay();
        }
    });
}

function clearMessageAfterDelay() {
    setTimeout(() => {
        message.value = '';
        messageType.value = '';
    }, 4000);
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
                class="px-4 py-2 rounded-md bg-gradient-to-r from-pink-600 to-rose-500 hover:from-pink-700 hover:to-rose-600 text-white font-semibold transition-all duration-200"
            >
                Subscribe
            </button>

            <p
                v-if="message"
                :class="{
          'text-sm mt-1': true,
          'text-green-600 dark:text-green-400': messageType === 'success',
          'text-yellow-600 dark:text-yellow-400': messageType === 'warning'
        }"
            >
                {{ message }}
            </p>
        </form>
    </div>
</template>
