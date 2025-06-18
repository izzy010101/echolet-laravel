<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'
import {watch} from 'vue';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});

watch(() => form.name, (val) => {
    if (val.length > 2) form.errors.name = null;
});
watch(() => form.email, (val) => {
    if (val.includes('@')) form.errors.email = null;
});

const submit = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            Inertia.reload({only: ['auth']});
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">Profile Information</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <!-- Name -->
            <div>
                <InputLabel for="name" value="Name"/>
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    autocomplete="name"
                    class="mt-1 block w-full"
                    :class="form.errors.name ? 'border-red-500' : ''"
                />
                <InputError :message="form.errors.name" class="mt-2"/>
            </div>

            <!-- Email -->
            <div>
                <InputLabel for="email" value="Email"/>
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    autocomplete="username"
                    class="mt-1 block w-full"
                    :class="form.errors.email ? 'border-red-500' : ''"
                />
                <InputError :message="form.errors.email" class="mt-2"/>
            </div>

            <!-- Email Verification Notice -->
            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800 dark:text-gray-300">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="text-sm underline text-gray-600 dark:text-gray-300 hover:text-gray-900 focus:outline-none"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>
                <div v-show="status === 'verification-link-sent'"
                     class="mt-2 text-sm text-green-600 dark:text-green-300">
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-4">
                <PrimaryButton
                    :disabled="form.processing"
                    :class="{ 'opacity-50': form.processing }"
                    class="bg-rose-500 hover:bg-rose-600 text-white dark:bg-purple-500 dark:hover:bg-purple-600"
                >
                    Save
                </PrimaryButton>
                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-300">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
