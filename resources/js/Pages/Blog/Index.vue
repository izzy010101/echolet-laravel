<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

defineProps({
    auth: Object,
    posts: Array,
    categories: Array,
    footerCategories: Array,
    searchQuery: String,
    selectedCategory: String
})
</script>

<template>
    <Head title="Blog" />
    <AppLayout :auth="auth" :footer-categories="footerCategories">
        <div class="max-w-7xl mx-auto py-16 px-6">

            <!-- Hero -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Explore Stories</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Dive into articles from all categories</p>
            </div>

            <!-- Categories -->
            <div class="flex flex-wrap gap-3 justify-center mb-12">
                <Link
                    :href="route('blog.index')"
                    :class="[
            'px-4 py-1.5 rounded-full border text-sm transition',
            !selectedCategory
              ? 'bg-rose-500 text-white border-rose-500'
              : 'bg-white dark:bg-gray-800 text-gray-800 dark:text-white border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700'
          ]"
                >
                    All
                </Link>
                <Link
                    v-for="category in categories"
                    :key="category.id"
                    :href="route('blog.index', { category: category.name })"
                    :class="[
            'px-4 py-1.5 rounded-full border text-sm transition',
            selectedCategory === category.name
              ? 'bg-rose-500 text-white border-rose-500'
              : 'bg-white dark:bg-gray-800 text-gray-800 dark:text-white border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700'
          ]"
                >
                    {{ category.name }}
                </Link>
            </div>

            <!-- Posts Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
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
    </AppLayout>
</template>
