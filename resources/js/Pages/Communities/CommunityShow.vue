<script setup>
import { Link } from "@inertiajs/vue3";
import PostCard from "@/Components/PostCard.vue";
import LayoutPicker from "@/Components/LayoutPicker.vue"
import {ref} from "vue";

defineProps({
    community: Object,
    posts: Object,
});

const form = ref({
    processing: false,
});
</script>

<template>
    <LayoutPicker>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl leading-tight my-auto">
                    s/{{ community.name }}
                </h2>
                <div v-if="$page.props.auth.auth_check">
                    <Link :href="route('communities.posts.create', community.slug)" class="btn btn-success uppercase">
<!--                        :disabled="form.processing"-->
                        Create Post
                    </Link>
                </div>
            </div>
        </template>

        <div class="m-2 p-2 flex flex-col md:flex-row">
            <div class="w-full md:w-4/12 p-4 order-1 md:order-2">
                <div class="w-full shadow-md rounded-xl border border-secondary bg-base-100">
                    <h2 class="font-semibold text-lg p-6 rounded-t-xl bg-secondary">
                        About {{ community.name }}
                    </h2>
                    <p class="p-4 rounded-b-xl">
                        {{ community.description }}
                    </p>
                </div>

                <!-- Uncomment the following if you want to include the CommunityList section -->
                <!--
                <CommunityList class="mt-4" :communities="community">
                    <template #title>
                        Latest Communities
                    </template>
                </CommunityList>
                -->
            </div>

            <div class="w-full md:w-8/12 order-2 md:order-1">
                <PostCard v-for="post in posts.data" :post="post" :community="community.slug" :key="post.id"/>
            </div>
        </div>
    </LayoutPicker>
</template>
