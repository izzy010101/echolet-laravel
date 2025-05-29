<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { User, Mail, Lock, LogIn } from 'lucide-vue-next'

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <div class="min-h-screen bg-gradient-to-br from-pink-50 via-purple-50 to-rose-50 flex items-center justify-center p-4">
            <div class="w-full max-w-md space-y-6">
                <!-- Title -->
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-purple-500 to-rose-400 rounded-2xl mb-4 shadow-lg">
                        <User class="w-8 h-8 text-white" />
                    </div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                        Create Your Account
                    </h1>
                    <p class="text-gray-600 mt-2">Sign up to get started</p>
                </div>

                <!-- Form -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl border border-white/20 p-8">
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <User class="w-4 h-4 text-purple-500" />
                                Name
                            </label>
                            <input
                                v-model="form.name"
                                type="text"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="Your full name"
                                class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400 mt-1"
                            />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <Mail class="w-4 h-4 text-purple-500" />
                                Email Address
                            </label>
                            <input
                                v-model="form.email"
                                type="email"
                                required
                                autocomplete="username"
                                placeholder="you@example.com"
                                class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400 mt-1"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <Lock class="w-4 h-4 text-purple-500" />
                                Password
                            </label>
                            <input
                                v-model="form.password"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="Choose a password"
                                class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400 mt-1"
                            />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <!-- Password Confirmation -->
                        <div>
                            <label class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <Lock class="w-4 h-4 text-purple-500" />
                                Confirm Password
                            </label>
                            <input
                                v-model="form.password_confirmation"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="Repeat your password"
                                class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400 mt-1"
                            />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>

                        <!-- Submit -->
                        <PrimaryButton
                            class="w-full justify-center bg-gradient-to-r from-purple-500 to-rose-400 hover:from-purple-600 hover:to-rose-500 text-white font-semibold py-3 rounded-xl transition-all duration-200 shadow-lg"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            <span class="flex items-center justify-center gap-2">
                                <LogIn class="w-5 h-5" />
                                Sign Up
                            </span>
                        </PrimaryButton>
                    </form>

                    <!-- Login Link -->
                    <p class="text-center text-sm text-gray-600 mt-6">
                        Already have an account?
                        <Link href="/login" class="font-medium text-purple-500 hover:text-purple-600">Log in here</Link>
                    </p>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
.backdrop-blur-sm {
  backdrop-filter: blur(8px);
}
</style>
