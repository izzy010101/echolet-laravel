<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import NoResults from '@/Components/NoResults.vue'

const props = defineProps({
    featured: Object,
    posts: Array,
    auth: Object,
    footerCategories: Array,
})
</script>

<template>
    <Head title="Home" />

    <AppLayout :auth="auth" :footer-categories="footerCategories">
        <section class="py-16 lg:py-24">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Title -->
                <div class="text-center mb-16">
                    <h1 class="text-4xl font-bold text-black dark:text-white">
                        Welcome to Echolet
                    </h1>
                    <p class="text-lg text-gray-700 dark:text-gray-300 mt-2">
                        Stories, insights, and advice from developers and founders building in the modern web.
                    </p>
                </div>

                <!-- Featured Article -->
                <div v-if="featured" class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-6 sm:p-8 lg:p-12 mb-16">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                        <div>
                            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">
                                {{ featured.title }}
                            </h2>
                            <p class="text-base sm:text-lg text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                                {{ featured.excerpt }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                Published: {{ new Date(featured.published_at).toLocaleDateString() }}
                            </p>
                            <Link
                                :href="route('posts.show', featured.id)"
                                class="inline-flex items-center px-5 py-2.5 bg-gray-900 text-white font-medium rounded-lg hover:bg-gray-800 transition"
                            >
                                Read Full Story
                            </Link>
                        </div>
                        <div>
                            <img
                                :src="featured.image ?? '/images/sample.jpg'"
                                alt="Featured"
                                class="w-full h-auto object-cover rounded-xl shadow"
                            />
                        </div>
                    </div>
                </div>

                <!-- Latest Stories -->
                <div v-if="posts.length > 0" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="post in posts"
                        :key="post.id"
                        class="flex flex-col bg-white dark:bg-gray-800 p-6 rounded-xl shadow hover:shadow-lg transition min-h-[380px]"
                    >
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ post.title }}</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4 flex-grow">{{ post.excerpt }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                            Published: {{ new Date(post.published_at).toLocaleDateString() }}
                        </p>
                        <Link
                            :href="route('posts.show', post.id)"
                            class="mt-auto self-start text-sm text-rose-500 hover:underline dark:text-rose-400"
                        >
                            Read more →
                        </Link>
                    </div>
                </div>

                <!-- No Results Card  -->
                <NoResults v-if="!featured && posts.length === 0" />
            </div>
        </section>
    </AppLayout>
</template>
