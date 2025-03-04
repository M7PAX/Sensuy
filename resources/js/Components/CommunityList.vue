<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    communities: Array
})
</script>

<template>
    <div class="w-full shadow-md rounded-xl border border-primary bg-base-100">
        <h2 class="font-semibold text-lg p-6 rounded-lg bg-primary">
            <slot name="title"></slot>
        </h2>
        <ul role="list" class="divide-y">
            <li v-for="community in communities" :key="community.id" class="py-3 px-5 sm:py-4">
                <div class="flex items-center space-x-4">
                    <Link :href="route('frontend.communities.show', community.slug)" class="font-semibold truncate text-sm w-3/5">
                        {{ community.name }}
                    </Link>
                    <div class="w-full">
                        Posts - {{ community.posts_count }}
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>
