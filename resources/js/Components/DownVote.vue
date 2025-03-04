<script setup>
import {Link} from "@inertiajs/vue3";
import {BiArrowDownCircleFill} from "oh-vue-icons/icons";
import {addIcons} from "oh-vue-icons";
addIcons(BiArrowDownCircleFill);

defineProps({
    slug: String
})
</script>

<template>
    <Link :href="route('posts.downVote', slug)" preserve-scroll method="post" as="button"  type="button" class="hover:text-error flex justify-center my-2">
        <v-icon name="bi-arrow-down-circle-fill" fill="currentColor" class="size-6"/>
    </Link>
</template>
