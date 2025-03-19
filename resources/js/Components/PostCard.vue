<script setup>
import {Link} from "@inertiajs/vue3";
import PostVote from "@/Components/PostVote.vue";

defineProps({
    post: Object,
    community: String,
});
</script>

<template>
    <Link :href="route('posts', [community, post.slug])" class="mt-4 max-w-4xl flex shadow-md bg-base-100 border border-primary rounded-xl">
        <div class="mr-3">
            <PostVote :post="post"/>
        </div>
        <div>
            <div class="flex my-2 py-2 text-sm">
                <Link :href="route('communities',community)"
                      class="font-semibold mr-5 hover:text-secondary">
                      {{ community }}
                </Link>
                <div class="flex text-base-content/50">
                    Posted by
                    <span class="text-base-content font-semibold ml-1">
                        {{ post.username }}
                    </span>
                    <span class="ml-5">
                        {{ post.created_at }}
                    </span>
                </div>
            </div>
            <h5 class="mb-2 text-2xl font-bold tracking-tight hover:text-secondary">
                {{ post.title }}
            </h5>
            <p class="mb-3 mr-3 font-normal">
                {{ post.description }}
            </p>

            <div v-if="post.files.length" class="m-4">
                <div v-for="file in post.files" :key="file.id" class="mb-4">
                    <div v-if="file.mime_type.startsWith('image')" class="mt-2">
                        <img :src="file.url" class="rounded-xl max-w-full h-auto"/>
                    </div>
                    <div v-else-if="file.mime_type.startsWith('video')" class="mt-2">
                        <video controls class="rounded-lg max-w-full h-auto">
                            <source :src="file.url" :type="file.mime_type">
                        </video>
                    </div>
                    <div v-else-if="file.mime_type.startsWith('audio')" class="mt-2">
                        <audio controls class="rounded-lg w-full">
                            <source :src="file.url" :type="file.mime_type">
                        </audio>
                    </div>
                </div>
            </div>

            <div class="flex my-2 py-2 text-base-content/50">
                Comments - {{ post.comments_count }}
            </div>
        </div>
    </Link>
</template>
