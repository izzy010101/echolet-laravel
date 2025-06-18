<script setup>
import { useForm, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

const validationErrors = ref({
    current_password: '',
    password: '',
    password_confirmation: ''
})

// Live validation
watch(() => form.current_password, (value) => {
    if (value.length > 0) {
        validationErrors.value.current_password = ''
        form.clearErrors('current_password')
    } else {
        validationErrors.value.current_password = 'Current password is required.'
    }
})

watch(() => form.password, (value) => {
    if (value.length >= 6) {
        validationErrors.value.password = ''
        form.clearErrors('password')
    } else {
        validationErrors.value.password = 'Password must be at least 6 characters.'
    }
})

watch(() => form.password_confirmation, (value) => {
    if (value === form.password) {
        validationErrors.value.password_confirmation = ''
        form.clearErrors('password_confirmation')
    } else {
        validationErrors.value.password_confirmation = 'Passwords do not match.'
    }
})


const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            validationErrors.value = {
                current_password: '',
                password: '',
                password_confirmation: ''
            }
            window.location.href = route('login') // logout and go to login
        }
    })
}
</script>

<template>
    <section>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Update Password</h2>

        <form @submit.prevent="updatePassword" class="space-y-6">

            <!-- Current Password -->
            <div>
                <InputLabel for="current_password" value="Current Password" />
                <TextInput
                    id="current_password"
                    v-model="form.current_password"
                    type="password"
                    autocomplete="current-password"
                    class="mt-1 block w-full"
                    :class="{ 'border-red-500': validationErrors.current_password || form.errors.current_password }"
                />
                <InputError :message="validationErrors.current_password || form.errors.current_password || ''" class="mt-2" />
            </div>

            <!-- New Password -->
            <div>
                <InputLabel for="password" value="New Password" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    autocomplete="new-password"
                    class="mt-1 block w-full"
                    :class="{ 'border-red-500': validationErrors.password || form.errors.password }"
                />
                <InputError :message="validationErrors.password || form.errors.password || ''" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    class="mt-1 block w-full"
                    :class="{ 'border-red-500': validationErrors.password_confirmation || form.errors.password_confirmation }"
                />
                <InputError :message="validationErrors.password_confirmation || form.errors.password_confirmation || ''" class="mt-2" />
            </div>

            <div class="flex justify-start">
                <PrimaryButton
                    :disabled="form.processing"
                    class="bg-rose-500 hover:bg-rose-600 text-white dark:bg-purple-500 dark:hover:bg-purple-600 transition"
                    :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                >
                    Save
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>
