<script setup>
import {Link} from "@inertiajs/vue3";
import PostVote from "@/Components/PostVote.vue";

defineProps({
    post: Object,
    community: Object,
});
</script>

<template>
    <Link :href="route('frontend.communities.posts.show', [community, post.slug])"
        class="mt-4 max-w-4xl flex text-gray-400 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 shadow-md"
    >
        <div class="mr-3">
            <PostVote :post="post"/>
        </div>
        <div>
            <div class="flex my-2 py-2 text-sm">
                <Link :href="route('frontend.communities.show',community)"
                      class="font-semibold text-black dark:text-white mr-5 hover:text-blue-700 dark:hover:text-blue-500">
                      r/{{ community }}
                </Link>
                <div class="flex">
                    Posted by
                    <span class="font-semibold text-black dark:text-white ml-1">
                        {{ post.username }}
                    </span>
                    <span class="ml-5">
                        {{ post.created_at }}
                    </span>
                </div>
            </div>
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-black dark:text-white hover:text-blue-700 dark:hover:text-blue-500">
                {{ post.title }}
            </h5>
            <p class="mb-3 mr-3 font-normal text-gray-600 dark:text-gray-400">
                {{ post.description }}
            </p>
            <div class="flex my-2 py-2 text-gray-700 dark:text-gray-300">
                Comments({{ post.comments_count }})
            </div>
        </div>
    </Link>
</template>
