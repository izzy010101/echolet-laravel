<!-- resources/js/Components/CommentItem.vue -->
<script setup>
import { ref } from 'vue';
import CommentForm from './CommentForm.vue';
import axios from 'axios';

const props = defineProps({
    comment: Object,
    postId: Number,
    auth: Object
});

const showReplyForm = ref(false);
const replying = ref(false);
const showEditForm = ref(false);
const editing = ref(false);
const isLiked = ref(props.comment.likes.some(like => like.user_id === props.auth?.id));
const likesCount = ref(props.comment.likes.length);

const toggleLike = async () => {
    if (!props.auth) return;

    try {
        const res = await axios.post(`/comments/${props.comment.id}/like`);
        isLiked.value = res.data.liked;
        likesCount.value = res.data.likes_count;
    } catch (err) {
        console.error(err);
    }
};
</script>

<template>
    <div class="border rounded-lg p-4 bg-white dark:bg-gray-800">
        <div class="flex justify-between items-start">
            <div>
                <p class="font-semibold">{{ comment.user.name }}</p>
                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ comment.body }}</p>
            </div>

            <div class="text-sm text-gray-500">
                <button v-if="auth" @click="toggleLike" class="mr-2">
                    {{ isLiked ? '💖' : '🤍' }} {{ likesCount }}
                </button>

                <button v-if="auth && comment.user.id === auth.id" @click="showEditForm = !showEditForm">✏️</button>
                <button v-if="auth && comment.user.id === auth.id" @click="$inertia.delete(`/comments/${comment.id}`)">🗑️</button>
                <button v-if="auth" @click="showReplyForm = !showReplyForm">↪️ Reply</button>
            </div>
        </div>

        <div v-if="showEditForm" class="mt-2">
            <CommentForm
                :post-id="postId"
                :auth="auth"
                :parent-id="comment.parent_id"
                :edit-mode="true"
                :existing-comment="comment"
                @submitted="showEditForm = false"
            />
        </div>

        <div v-if="showReplyForm" class="mt-2">
            <CommentForm
                :post-id="postId"
                :auth="auth"
                :parent-id="comment.id"
                @submitted="showReplyForm = false"
            />
        </div>

        <div v-if="comment.replies?.length" class="pl-6 mt-4 border-l-2 dark:border-gray-700 space-y-2">
            <CommentItem
                v-for="reply in comment.replies"
                :key="reply.id"
                :comment="reply"
                :post-id="postId"
                :auth="auth"
            />
        </div>
    </div>
</template>
