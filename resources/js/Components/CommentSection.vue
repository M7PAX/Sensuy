<script setup>
import {Link} from "@inertiajs/vue3";
import {RiUser3Line} from "oh-vue-icons/icons";
import {addIcons} from "oh-vue-icons";
addIcons(RiUser3Line);

const props = defineProps({
    post: Object,
    community: String,
});

</script>

<template>
    <div v-if="post.data.comments.length !== 0" class="bg-base-100 rounded-box border border-secondary shadow-md my-5">
        <ul role="list" class="divide-y divide-secondary mx-5">
            <li v-for="(comment, index) in post.data.comments" :key="index" class="py-4 flex flex-col">
                <div class="text-sm ml-3 mb-1 justify-between flex flex-row">
                    <div class="flex">
                        <div class="avatar mr-2">
                            <div :class="['mask', 'w-8', 'bg-accent', comment.is_admin ? 'mask-hexagon' : 'mask-hexagon-2']">
                                <v-icon v-if="comment.user_picture === null" name="ri-user-3-line" class="w-8 h-8 text-base-100 mt-0.5"/>
                                <img v-else :src="`/storage/${comment.user_picture}`" alt="Profile Picture"/>
                            </div>
                        </div>

                        <span class="font-semibold text-base-content my-auto">
                            {{ comment.username }}
                        </span>

                        <span class="ml-3 text-base-content/50 my-auto">
                            {{ comment.created_at }}
                        </span>
                    </div>

                    <div class="flex items-center">
                        <Link v-if="comment.can_update" :href="route('communities.posts.comments.edit', [community, post.data.slug, comment.id])" class="btn btn-xs btn-warning uppercase mr-3" method="get" type="button">
                            {{ $t('edit') }}
                        </Link>

                        <Link v-if="comment.can_delete" :href="route('communities.posts.comments.destroy', [community, post.data.slug, comment.id])" class="btn btn-xs btn-error uppercase" method="delete" type="button">
                            {{ $t('delete') }}
                        </Link>
                    </div>
                </div>

                <div class="ml-5">
                    {{ comment.content }}
                </div>
            </li>
        </ul>
    </div>

    <div v-else class="bg-base-100 rounded-box border border-secondary shadow-md my-5 text-warning text-xl flex items-center justify-center">
        <div class="my-5">
            {{ $t('no comments') }}
        </div>
    </div>
</template>
