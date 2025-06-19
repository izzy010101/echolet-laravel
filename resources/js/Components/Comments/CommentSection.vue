<!-- resources/js/Components/CommentsSection.vue -->
<script setup>
import CommentItem from './CommentItem.vue';

const props = defineProps({
    comments: Array,
    postId: Number,
    auth: Object,
    footerCategories: Array,
});
</script>

<template>
    <div class="space-y-6">
        <h2 class="text-xl font-semibold mb-2">Comments</h2>

        <CommentItem
            v-for="comment in comments"
            :key="comment.id"
            :comment="comment"
            :post-id="postId"
            :auth="auth"
        />
    </div>
</template>
