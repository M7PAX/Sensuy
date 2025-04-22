<script setup>
import { Link } from "@inertiajs/vue3";
import { HiUserGroup } from "oh-vue-icons/icons";
import { addIcons } from "oh-vue-icons";
addIcons(HiUserGroup);

defineProps({
    communities: Object
})
</script>

<template>
    <div class="w-full shadow-md rounded-box border border-secondary bg-base-100">
        <h2 class="font-semibold text-lg p-6 rounded-field bg-secondary">
            <slot name="title"></slot>
        </h2>

        <ul role="list" class="divide-y">
            <li v-for="community in communities" :key="community.id" class="py-3 px-5 sm:py-4">
                <div class="flex items-center">
                    <Link :href="route('communities', community.slug)" class="font-semibold truncate text-sm w-3/4   hover:text-accent group">
                        <div class="avatar mr-2">
                            <div class="mask mask-heart w-8 bg-primary group-hover:bg-accent">
                                <v-icon v-if="community.picture === null" name="hi-user-group" class="w-8 h-8 text-base-100 mt-1"/>
                                <img v-else :src="`/storage/${community.picture}`" alt="Community Picture"/>
                            </div>
                        </div>
                        {{ community.name }}
                    </Link>

                    <div class="w-fit">
                        {{ $t('posts') }} - {{ community.posts_count }}
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>
