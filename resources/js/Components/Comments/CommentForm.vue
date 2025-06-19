<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    postId: Number,
    user: Object,
    parentId: {
        type: Number,
        default: null,
    },
})

const emit = defineEmits(['submitted'])

const form = useForm({
    content: '',
    post_id: props.postId,
    parent_id: props.parentId,
})

const submit = () => {
    form.post(route('comments.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            emit('submitted')
        },
    })
}
</script>

<template>
    <form @submit.prevent="submit" class="space-y-3">
        <textarea
            v-model="form.content"
            class="w-full p-3 border border-gray-300 rounded dark:bg-gray-800 dark:text-white dark:border-gray-600"
            rows="3"
            placeholder="Write a comment..."
        ></textarea>

        <div v-if="form.errors.content" class="text-sm text-red-500">
            {{ form.errors.content }}
        </div>

        <button
            type="submit"
            class="bg-rose-500 text-white px-4 py-2 rounded hover:bg-rose-600 transition"
        >
            Post Comment
        </button>
    </form>
</template>
