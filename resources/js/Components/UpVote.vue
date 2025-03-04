<script setup>
import {Link} from "@inertiajs/vue3";
import {BiArrowUpCircleFill} from "oh-vue-icons/icons";
import {addIcons} from "oh-vue-icons";
addIcons(BiArrowUpCircleFill);

defineProps({
    slug: String
})
</script>

<template>
    <Link :href="route('posts.upVote', slug)" preserve-scroll method="post" as="button" type="button" class="hover:text-success flex justify-center my-2">
        <v-icon name="bi-arrow-up-circle-fill" fill="currentColor" class="size-6"/>
    </Link>
</template>
