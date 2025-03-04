<script setup>
import { Link } from "@inertiajs/vue3";
import PostCard from "@/Components/PostCard.vue";
import Pagination from "@/Components/Pagination.vue";
import {ref} from "vue";
import LayoutPicker from "@/Components/LayoutPicker.vue";

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
        <div class="card card-xl shadow-sm bg-base-100">
            <div class="card-body">
                <h2 class="card-title font-semibold text-xl leading-tight justify-between">
                    s/{{ community.name }}
                    <button v-if="$page.props.auth.auth_check" class="btn btn-success" :disabled="form.processing">
                        <Link :href="route('communities.posts.create', community.slug)">
                            Create Post
                        </Link>
                    </button>
                </h2>
            </div>
        </div>

        <div class="m-2 p-2 flex flex-col md:flex-row">
            <div class="w-full md:w-4/12 p-4 order-1 md:order-2">
                <div class="w-full shadow-md rounded-xl border border-primary">
                    <h2 class="font-semibold text-lg p-6 rounded-t-xl bg-primary">
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
                <div class="mt-4 p-2">
                    <Pagination :links="posts.meta.links"/>
                </div>
            </div>
        </div>
    </LayoutPicker>
</template>
