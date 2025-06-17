<script setup>
import { computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Mail } from 'lucide-vue-next';

const props = defineProps({
    status: String,
    auth: Object,
    footerCategories: Array
});

const form = useForm({});
const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <AppLayout :auth="auth" :footer-categories="footerCategories">
        <Head title="Email Verification"/>

        <div class="flex justify-center items-center min-h-[80vh] px-4 mt-24 mb-16">
            <div
                class="w-full max-w-md bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-3xl shadow-xl border border-white/20 dark:border-gray-700 p-8 space-y-6">
                <!-- Title -->
                <div class="text-center">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-purple-500 to-rose-400 rounded-2xl mb-4 shadow-lg">
                        <Mail class="w-8 h-8 text-white"/>
                    </div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent dark:from-white dark:to-gray-300">
                        Verify Your Email
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
                        Thanks for signing up! Please verify your email address by clicking the link we just emailed to
                        you.
                        If you didn’t receive the email, we’ll gladly send another.
                    </p>
                </div>

                <!-- Resend Alert -->
                <div v-if="verificationLinkSent" class="text-sm font-medium text-green-600 text-center">
                    A new verification link has been sent to your email.
                </div>

                <!-- Form -->
                <form @submit.prevent="submit" class="space-y-4">
                    <PrimaryButton
                        class="w-full justify-center bg-gradient-to-r from-purple-500 to-rose-400 hover:from-purple-600 hover:to-rose-500 text-white font-semibold py-3 rounded-xl transition-all duration-200 shadow-lg"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Resend Verification Email
                    </PrimaryButton>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.backdrop-blur-sm {
    backdrop-filter: blur(8px);
}
</style>
