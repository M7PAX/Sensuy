<script setup>
import {Link} from "@inertiajs/vue3";
import PostVote from "@/Components/PostVote.vue";
import {RiUser3Line, HiUserGroup} from "oh-vue-icons/icons";
import {addIcons} from "oh-vue-icons";
addIcons(RiUser3Line, HiUserGroup);

defineProps({
    post: Object,
    community: String,
});
</script>

<template>
    <Link :href="route('posts', [community, post.slug])" class="mt-4 max-w-4xl flex shadow-md bg-base-100 border border-primary rounded-box">
        <div class="mr-3">
            <PostVote :post="post"/>
        </div>
        <div>
            <div class="flex mt-4 mb-2 text-sm">
                <Link :href="route('communities',community)" class="font-semibold hover:text-secondary group">
                    <div class="avatar mr-2">
                        <div class="mask mask-heart w-8 bg-primary group-hover:bg-secondary">
                            <v-icon v-if="post.community_picture === null" name="hi-user-group" class="w-8 h-8 text-base-100 mt-1"/>
                            <img v-else :src="`/storage/${post.community_picture}`" alt="Community Picture"/>
                        </div>
                    </div>
                    {{ community }}
                </Link>
                <span class="ml-5 text-base-content/50 my-auto">
                        {{ post.created_at }}
                </span>
                <div class="ml-auto mr-4">
                    <div class="avatar mr-2">
                        <div class="mask mask-hexagon-2 w-8 bg-accent">
                            <v-icon v-if="post.user_picture === null" name="ri-user-3-line" class="w-8 h-8 text-base-100 mt-0.5"/>
                            <img v-else :src="`/storage/${post.user_picture}`" alt="Profile Picture"/>
                        </div>
                    </div>
                    <span class="text-base-content font-semibold">
                        {{ post.username }}
                    </span>
                </div>
            </div>
            <h5 class="mb-2 text-2xl font-bold tracking-tight">
                {{ post.title }}
            </h5>
            <p class="mb-3 mr-3 font-normal">
                {{ post.description }}
            </p>

            <div v-if="post.files.length" class="m-4">
                <div v-for="file in post.files" :key="file.id" class="mb-4">
                    <div v-if="file.mime_type.startsWith('image')" class="mt-2">
                        <img :src="file.url" class="rounded-selector max-w-full h-auto"/>
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

            <div class="flex my-2 py-2 text-accent">
                {{ $t('comments') }} - {{ post.comments_count }}
            </div>
        </div>
    </Link>
</template>
