<!-- resources/js/Components/CommentForm.vue -->
<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    postId: Number,
    auth: Object,
    parentId: {
        type: Number,
        default: null,
    },
    editMode: {
        type: Boolean,
        default: false,
    },
    existingComment: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(['submitted']);

const form = useForm({
    body: props.editMode && props.existingComment ? props.existingComment.body : '',
    post_id: props.postId,
    parent_id: props.parentId,
});

watch(() => props.editMode, () => {
    if (props.editMode && props.existingComment) {
        form.body = props.existingComment.body;
    }
});

const submit = () => {
    if (props.editMode && props.existingComment) {
        form.put(`/comments/${props.existingComment.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                emit('submitted');
            },
        });
    } else {
        form.post('/comments', {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                emit('submitted');
            },
        });
    }
};
</script>

<template>
    <form @submit.prevent="submit" class="mt-2">
    <textarea
        v-model="form.body"
        placeholder="Write a comment..."
        rows="3"
        class="w-full p-2 border dark:border-gray-700 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
    ></textarea>
        <div class="mt-2 flex justify-end space-x-2">
            <button
                type="submit"
                class="px-4 py-1 rounded bg-purple-600 text-white hover:bg-purple-700 transition"
                :disabled="form.processing"
            >
                {{ editMode ? 'Update' : 'Post' }}
            </button>
        </div>
        <div v-if="form.errors.body" class="text-sm text-red-500 mt-1">{{ form.errors.body }}</div>
    </form>
</template>

