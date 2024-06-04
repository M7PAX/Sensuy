<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Link } from "@inertiajs/vue3";
import PostCard from "@/Components/PostCard.vue";
import Pagination from "@/Components/Pagination.vue";
import CommunityList from "@/Components/CommunityList.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    community: Object,
    posts: Object,
});
</script>

<template>
    <guest-layout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-black dark:text-white leading-tight">
                    s/{{ community.name }}
                </h2>
                <PrimaryButton>
                    <Link v-if="$page.props.auth.auth_check" :href="route('communities.posts.create', community.slug)">
                        Create Post
                    </Link>
                </PrimaryButton>
            </div>
        </template>

        <section class="m-2 p-2 md:flex-row flex">
            <div class="w-8/12">
                <PostCard v-for="post in posts.data" :post="post" :community="community.slug" :key="post.id"/>
                <div class="mt-4 p-2">
                    <Pagination :links="posts.meta.links"/>
                </div>
            </div>

            <div class="w-4/12 p-4">
                <div class="w-full shadow-md rounded-lg border border-blue-500 dark:border-blue-700 bg-white dark:bg-gray-800">
                    <h2 class="font-semibold text-lg p-6 rounded-t-lg text-white bg-blue-500 dark:bg-blue-700">
                        About {{ community.name }}
                    </h2>
                    <p class="p-4 rounded-b-lg text-gray-600 dark:text-gray-400">
                        {{ community.description }}
                    </p>
                </div>

<!--                <CommunityList class="mt-4" :communities="community">-->
<!--                    <template #title>-->
<!--                        Latest Communities-->
<!--                    </template>-->
<!--                </CommunityList>-->
            </div>

        </section>
    </guest-layout>
</template>
