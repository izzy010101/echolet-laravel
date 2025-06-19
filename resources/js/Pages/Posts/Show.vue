<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import CommentsSection from '@/Components/Comments/CommentSection.vue'
import { Head } from '@inertiajs/vue3'

const props = defineProps({
    post: Object,
    auth: Object,
    comments: Array,
    footerCategories: Array,
})
</script>

<template>
    <AppLayout :auth="auth" :footer-categories="footerCategories" page="post">
        <Head :title="post.title" />

        <main class="max-w-4xl mx-auto p-8">
            <h1 class="text-4xl font-bold mb-6">{{ post.title }}</h1>
            <article class="prose dark:prose-invert" v-html="post.body"></article>

            <CommentsSection
                class="mt-12"
                :comments="comments"
                :post-id="post.id"
                :auth="auth"
            />
        </main>
    </AppLayout>
</template>
