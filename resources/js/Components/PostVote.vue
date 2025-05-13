<script setup>
import { Link } from "@inertiajs/vue3";
import { BiArrowUpCircleFill, BiArrowDownCircleFill } from "oh-vue-icons/icons";
import { addIcons } from "oh-vue-icons";
addIcons(BiArrowUpCircleFill, BiArrowDownCircleFill);

defineProps({
    post: Object
});
</script>

<template>
    <div class="w-12 flex flex-col h-full p-2 text-center">
        <Link :href="post.voted[0]?.vote === 1 ? route('posts.removeVote', post.slug) : route('posts.upVote', post.slug)"
            preserve-scroll method="post" as="button" type="button"
            class="hover:text-success flex justify-center my-2"
            :class="{ 'text-success': post.voted[0]?.vote === 1 }"
        >
            <v-icon name="bi-arrow-up-circle-fill" fill="currentColor" class="size-6"/>
        </Link>

        <div class="p-2 my-2 font-bold" :class="{'text-success': post.voted[0]?.vote === 1,'text-error': post.voted[0]?.vote === -1}">
            {{ post.votes }}
        </div>

        <Link :href="post.voted[0]?.vote === -1 ? route('posts.removeVote', post.slug) : route('posts.downVote', post.slug)"
            preserve-scroll method="post" as="button" type="button"
            class="hover:text-error flex justify-center my-2"
            :class="{ 'text-error': post.voted[0]?.vote === -1 }"
        >
            <v-icon name="bi-arrow-down-circle-fill" fill="currentColor" class="size-6"/>
        </Link>
    </div>
</template>
