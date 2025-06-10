<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    posts: {
        type: Array,
        default: () => [],
    },
    categories: {
        type: Array,
        default: () => [],
    },
    auth: Object,
});

const form = useForm({
    title: '',
    content: '',
    category_id: '',
});

const validationErrors = ref({
    title: '',
    content: '',
    category_id: ''
});

// Live Validation Watchers
watch(() => form.title, (value) => {
    if (value === '') {
        validationErrors.value.title = '';
        return;
    }
    validationErrors.value.title = value.length < 3 ? 'Title must be at least 3 characters.' : '';
});

watch(() => form.content, (value) => {
    validationErrors.value.content = value.length < 10 ? 'Content must be at least 10 characters.' : '';
});

watch(() => form.category_id, (value) => {
    validationErrors.value.category_id = value === '' ? 'Please select a category.' : '';
});

const submit = () => {
    form.post(route('posts.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            form.clearErrors();
            validationErrors.value = {
                title: '',
                content: '',
                category_id: ''
            };
        },
    });
};

const deletePost = (id) => {
    if (confirm('Are you sure you want to delete this post?')) {
        router.delete(route('posts.destroy', id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout :auth="props.auth">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left side: User Posts -->
                <div>
                    <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-100">Your Posts</h3>
                    <ul class="space-y-4">
                        <li
                            v-for="post in props.posts"
                            :key="post.id"
                            class="p-4 border rounded-xl bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100 shadow"
                        >
                            <h4 class="font-semibold text-lg">{{ post.title }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Posted on {{ new Date(post.created_at).toLocaleDateString() }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                {{ post.excerpt ?? (post.content?.slice(0, 50) + '...') ?? 'No content available.' }}
                            </p>
                            <div v-if="posts.length === 0" class="text-gray-500 dark:text-gray-400 mt-4">
                                You haven’t posted anything yet. Start by creating your first post!
                            </div>
                            <p class="text-xs italic text-gray-400 truncate">
                                Slug: {{ post.slug }}
                            </p>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs text-purple-500">
                                    Category: {{ post.category?.name || 'Uncategorized' }}
                                </span>
                                <div class="space-x-2">
                                    <button class="text-sm text-blue-600 hover:underline">Edit</button>
                                    <button @click="deletePost(post.id)" class="text-sm text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Right side: New Post Form -->
                <div>
                    <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-100">New Post</h3>
                    <div v-if="$page.props.flash.success" class="mb-4 text-green-600 dark:text-green-400 font-semibold">
                        {{ $page.props.flash.success }}
                    </div>
                    <form @submit.prevent="submit" class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Title</label>
                            <input
                                v-model="form.title"
                                type="text"
                                placeholder="Enter post title"
                                class="w-full px-4 py-2 rounded-lg border dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500"
                                :class="{
                                    'border-red-500': validationErrors.title || form.errors.title,
                                    'border-gray-300 dark:border-gray-600': !validationErrors.title && !form.errors.title
                                }"
                            />
                            <div v-if="validationErrors.title || form.errors.title" class="text-red-500 text-sm mt-1">
                                {{ validationErrors.title || form.errors.title }}
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Content</label>
                            <textarea
                                v-model="form.content"
                                rows="4"
                                placeholder="Write your post..."
                                class="w-full px-4 py-2 rounded-lg border dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500"
                                :class="{ 'border-red-500': form.errors.content, 'border-gray-300 dark:border-gray-600': !form.errors.content }"
                            ></textarea>
                            <div v-if="form.errors.content" class="text-red-500 text-sm mt-1">{{
                                    form.errors.content
                                }}
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Category</label>
                            <select
                                v-model="form.category_id"
                                class="w-full px-4 py-2 rounded-lg border dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500"
                                :class="{ 'border-red-500': form.errors.category_id, 'border-gray-300 dark:border-gray-600': !form.errors.category_id }"
                            >
                                <option value="">Select a category</option>
                                <option v-for="cat in props.categories" :key="cat.id" :value="cat.id">{{
                                        cat.name
                                    }}
                                </option>
                            </select>
                            <div v-if="form.errors.category_id" class="text-red-500 text-sm mt-1">
                                {{ form.errors.category_id }}
                            </div>
                        </div>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full bg-gradient-to-r from-purple-500 to-rose-500 hover:from-purple-600 hover:to-rose-600 text-white font-semibold py-2 px-4 rounded-xl transition-all duration-200 shadow-md"
                            :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                        >
                            Post
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
