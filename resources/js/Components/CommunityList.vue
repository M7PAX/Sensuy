<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    communities: Array
})
</script>

<template>
    <div class="w-full shadow-md rounded-lg bg-white dark:bg-gray-800 border border-blue-500 dark:border-blue-700">
        <h2 class="font-semibold text-lg p-6 bg-blue-500 dark:bg-blue-700 text-white rounded-lg">
            <slot name="title"></slot>
        </h2>
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-600">
            <li v-for="community in communities" :key="community.id" class="py-3 px-5 sm:py-4">
                <div class="flex items-center space-x-4">
                    <Link :href="route('frontend.communities.show', community.slug)"
                          class="text-black dark:text-white font-semibold truncate text-sm w-3/5"
                    >
                        {{ community.name }}
                    </Link>
                    <div class="text-gray-600 dark:text-gray-400 w-full">
                        Posts - {{ community.posts_count }}
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>
