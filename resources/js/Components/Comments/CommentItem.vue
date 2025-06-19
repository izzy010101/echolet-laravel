<script setup>
import CommentForm from './CommentForm.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    comment: Object,
    postId: Number,
    user: Object,
});

const showReplyForm = ref(false);
const showEditForm = ref(false);

function deleteComment(id) {
    router.delete(route('comments.destroy', id), {
        preserveScroll: true,
        preserveState: true,
    });
}
</script>

<template>
    <div class="border rounded bg-white dark:bg-gray-900 p-4 mb-2">
        <div v-if="!showEditForm">
            <strong>{{ comment.user.name }}</strong>
            <p class="mt-1 text-gray-700 dark:text-gray-300">{{ comment.content }}</p>
        </div>

        <CommentForm
            v-if="showEditForm"
            :post-id="postId"
            :parent-id="comment.parent_id"
            :auth="user"
            :initial-content="comment.content"
            :comment-id="comment.id"
            @submitted="showEditForm = false"
        />

        <div class="mt-2 flex space-x-2 items-center">
            <button
                v-if="user"
                @click="showReplyForm = !showReplyForm"
                class="text-xs text-pink-500 hover:underline"
            >
                Reply
            </button>

            <template v-if="user && user.id === comment.user.id">
                <button
                    @click="showEditForm = !showEditForm"
                    class="text-xs text-blue-500 hover:underline"
                >
                    Edit
                </button>
                <button
                    @click="deleteComment(comment.id)"
                    class="text-xs text-red-500 hover:underline"
                >
                    Delete
                </button>
            </template>
        </div>

        <CommentForm
            v-if="showReplyForm"
            :post-id="postId"
            :parent-id="comment.id"
            :auth="user"
            @submitted="showReplyForm = false"
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
