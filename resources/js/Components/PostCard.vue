<script setup>
import {Link} from "@inertiajs/vue3";
import PostVote from "@/Components/PostVote.vue";
import {RiUser3Line, HiUserGroup} from "oh-vue-icons/icons";
import {addIcons} from "oh-vue-icons";
addIcons(RiUser3Line, HiUserGroup);

defineProps({
    post: Object,
});
</script>

<template>
    <Link :href="route('posts', [post.community_slug, post.slug])" class="mt-4 max-w-4xl flex shadow-md bg-base-100 border border-primary rounded-field">
        <div class="mr-3">
            <PostVote :post="post"/>
        </div>

        <div class="w-full">
            <div class="flex mt-4 mb-2 text-sm mr-4">
                <Link :href="route('communities', post.community_slug)" class="font-semibold hover:text-secondary group">
                    <div class="avatar mr-2">
                        <div class="mask mask-heart w-8 bg-primary group-hover:bg-secondary">
                            <v-icon v-if="post.community_picture === null" name="hi-user-group" class="w-8 h-8 text-base-100 mt-1"/>
                            <img v-else :src="`/storage/${post.community_picture}`"/>
                        </div>
                    </div>
                    {{ post.community_name }}
                </Link>

                <span class="ml-5 text-base-content/50 my-auto">
                        {{ post.created_at_hum }}
                </span>

                <div class="ml-auto">
                    <div class="avatar mr-2">
                        <div :class="['mask', 'w-8', 'bg-accent', post.is_admin ? 'mask-hexagon' : 'mask-hexagon-2']">
                            <v-icon v-if="post.user_picture === null" name="ri-user-3-line" class="w-8 h-8 text-base-100 mt-0.5"/>
                            <img v-else :src="`/storage/${post.user_picture}`"/>
                        </div>
                    </div>

                    <span class="text-base-content font-semibold">
                        {{ post.username }}
                    </span>
                </div>
            </div>

            <h5 class="mb-2 mr-4 text-2xl font-bold tracking-tight text-wrap wrap-break-word">
                {{ post.title }}
            </h5>

            <p class="mb-2 mr-4 font-normal whitespace-pre-wrap text-wrap wrap-break-word">
                {{ post.description }}
            </p>

            <a :href="post.url" class="link">
                {{ post.url }}
            </a>

            <div v-if="post.files.length" class="m-4 mr-8">
                <div v-for="file in post.files" :key="file.id">
                    <div v-if="file.mime_type.startsWith('image')">
                        <img :src="file.url" class="rounded-field max-w-full max-h-screen"/>
                    </div>

                    <div v-else-if="file.mime_type.startsWith('video')">
                        <video controls class="rounded-field max-w-full max-h-screen">
                            <source :src="file.url" :type="file.mime_type">
                        </video>
                    </div>

                    <div v-else-if="file.mime_type.startsWith('audio')">
                        <audio controls class="rounded-field w-full">
                            <source :src="file.url" :type="file.mime_type">
                        </audio>
                    </div>
                </div>
            </div>

            <div class="flex my-2 py-2 text-secondary">
                {{ $t('comments') }} - {{ post.comments_count }}
            </div>
        </div>
    </Link>
</template>
