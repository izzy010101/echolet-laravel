<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Mail, Lock, Check, LogIn } from 'lucide-vue-next'

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div class="min-h-screen bg-gradient-to-br from-rose-50 via-pink-50 to-purple-50 flex items-center justify-center p-4">
            <div class="w-full max-w-md space-y-6">
                <!-- Title -->
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-rose-400 to-pink-500 rounded-2xl mb-4 shadow-lg">
                        <LogIn class="w-8 h-8 text-white" />
                    </div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                        Welcome Back
                    </h1>
                    <p class="text-gray-600 mt-2">Sign in to your account</p>
                </div>

                <!-- Flash Status -->
                <div v-if="status" class="text-sm font-medium text-green-600 text-center">
                    {{ status }}
                </div>

                <!-- Login Form -->
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl border border-white/20 p-8">
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Email -->
                        <div>
                            <label class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <Mail class="w-4 h-4 text-rose-500" />
                                Email Address
                            </label>
                            <input
                                v-model="form.email"
                                type="email"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="Enter your email"
                                class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-500 placeholder-gray-400 mt-1"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <Lock class="w-4 h-4 text-rose-500" />
                                Password
                            </label>
                            <input
                                v-model="form.password"
                                type="password"
                                required
                                autocomplete="current-password"
                                placeholder="Enter your password"
                                class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-rose-500 placeholder-gray-400 mt-1"
                            />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center space-x-2 cursor-pointer group">
                                <input type="checkbox" v-model="form.remember" class="sr-only" />
                                <div class="w-5 h-5 bg-gray-100 border-2 border-gray-200 rounded-md" :class="{ 'bg-rose-500 border-rose-500': form.remember }">
                                    <Check v-if="form.remember" class="w-3 h-3 text-white mx-auto mt-0.5" />
                                </div>
                                <span class="text-sm text-gray-600 group-hover:text-gray-800 transition">Remember me</span>
                            </label>
                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="text-sm font-medium text-rose-500 hover:text-rose-600"
                            >
                                Forgot password?
                            </Link>
                        </div>

                        <!-- Submit -->
                        <PrimaryButton
                            class="w-full justify-center bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white font-semibold py-3 rounded-xl transition-all duration-200 shadow-lg"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            <span class="flex items-center justify-center gap-2">
                                <LogIn class="w-5 h-5" />
                                Log in
                            </span>
                        </PrimaryButton>
                    </form>

                    <!-- Signup -->
                    <p class="text-center text-sm text-gray-600 mt-6">
                        Don’t have an account?
                        <Link href="/register" class="font-medium text-rose-500 hover:text-rose-600">Sign up for free</Link>
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
