<script setup>
import CommentForm from './CommentForm.vue';
import { ref } from 'vue';

const props = defineProps({
    comment: Object,
    postId: Number,
    user: Object,
});

const showReplyForm = ref(false);
</script>

<template>
    <div class="border rounded bg-white dark:bg-gray-900 p-4 mb-2">
        <div class="mb-2">
            <strong>{{ comment.user.name }}</strong>
            <p class="mt-1 text-gray-700 dark:text-gray-300">{{ comment.content }}</p>
        </div>

        <button
            v-if="user"
            @click="showReplyForm = !showReplyForm"
            class="text-xs text-pink-500 hover:underline"
        >
            Reply
        </button>

        <CommentForm
            v-if="showReplyForm"
            :post-id="postId"
            :parent-id="comment.id"
            :auth="user"
        />

        <div class="ml-4 mt-2 space-y-2">
            <CommentItem
                v-for="reply in comment.replies"
                :key="reply.id"
                :comment="reply"
                :post-id="postId"
                :user="user"
            />
        </div>
    </div>
</template>
