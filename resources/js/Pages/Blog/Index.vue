<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    posts: Array,
    categories: Array,
})
</script>

<template>
    <div class="min-h-screen bg-gradient-to-b from-pink-50 to-white dark:from-gray-950 dark:to-gray-900 py-16 px-6">
        <div class="max-w-7xl mx-auto">

            <!-- Hero -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Explore Stories</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Dive into articles from all categories</p>
            </div>

            <!-- Categories -->
            <div class="flex flex-wrap gap-3 justify-center mb-12">
        <span
            v-for="category in categories"
            :key="category.id"
            class="px-4 py-1.5 bg-white dark:bg-gray-800 text-sm rounded-full shadow text-gray-800 dark:text-white border border-gray-200 dark:border-gray-700"
        >
          {{ category.name }}
        </span>
            </div>

            <!-- Posts Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="post in posts"
                    :key="post.id"
                    class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow hover:shadow-lg transition flex flex-col"
                >
                    <span class="text-rose-500 dark:text-rose-400 text-xs font-semibold mb-2">{{ post.category.name }}</span>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ post.title }}</h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">{{ post.excerpt }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                        {{ post.user.name }} • {{ new Date(post.published_at).toLocaleDateString() }}
                    </p>
                    <Link :href="route('posts.show', post.id)" class="text-sm text-rose-500 hover:underline mt-auto">
                        Read more →
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
