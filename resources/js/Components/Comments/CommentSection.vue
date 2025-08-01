<script setup>
import CommentItem from './CommentItem.vue'
import CommentForm from './CommentForm.vue'

const props = defineProps({
    comments: {
        type: Array,
        default: () => []
    },
    postId: Number,
    user: Object,
})
</script>

<template>
    <div class="space-y-6">
        <!-- Always show form if logged in -->
        <CommentForm
            v-if="user"
            :post-id="postId"
            :user="user"
        />
        <p v-else class="text-gray-500 dark:text-gray-400">
            Please <a :href="route('login')" class="text-rose-500 hover:underline">login</a> to leave a comment.
        </p>

        <!-- Comments list or empty message -->
        <div v-if="comments.length > 0">
            <CommentItem
                v-for="comment in comments"
                :key="comment.id"
                :comment="comment"
                :post-id="postId"
                :user="user"
            />
        </div>
        <p v-else class="text-gray-500 dark:text-gray-400">
            No comments for this post yet.
        </p>
    </div>
</template>
