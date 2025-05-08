<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import PostVote from "@/Components/PostVote.vue";
import LayoutPicker from "@/Components/LayoutPicker.vue";
import {HiDownload, FaShare, HiUserGroup} from "oh-vue-icons/icons";
import {addIcons} from "oh-vue-icons";
import CommentSection from "@/Components/CommentSection.vue";
addIcons(HiDownload, FaShare, HiUserGroup);

const props = defineProps({
    community: Object,
    post: Object,
    can_update: Boolean,
    can_delete: Boolean,
    comments: Object,
});

const form = useForm({
    content: ""
});

const submit = () => {
    form.post(
        route('comments', [props.community.slug, props.post.data.slug]),{
            onSuccess: () => form.reset('content')
        }
    );
};

const copyLink = async () => {
    try {
        await navigator.clipboard.writeText(window.location.href);
    } catch (err) {
        console.error('Failed to copy link: ', err);
    }
};

</script>

<template>
    <LayoutPicker>
        <template #header>
            <div class="flex justify-between">
                <Link :href="route('communities', community.slug)" class="font-semibold text-xl leading-tight hover:text-secondary group my-auto">
                    <div class="avatar mr-2">
                        <div class="mask mask-heart w-10 bg-primary group-hover:bg-secondary">
                            <v-icon v-if="community.picture === null" name="hi-user-group" class="w-10 h-10 text-base-100 mt-1"/>
                            <img v-else :src="`/storage/${community.picture}`" alt="Community Picture"/>
                        </div>
                    </div>
                    s/{{ community.name }}
                </Link>
            </div>
        </template>

        <section class="flex flex-col p-2">
            <div class="w-full md:w-8/12 rounded-box border border-primary shadow-md bg-base-100">
                <div class="flex m-2 text-sm">
                    <div>
                        <PostVote :post="post.data"/>
                    </div>

                    <div class="w-full">
                        <div class="flex flex-col md:flex-row justify-between mx-2 mt-2">
                            <div>
                                <div class="avatar mr-2">
                                    <div class="mask mask-hexagon-2 w-8 bg-accent">
                                        <v-icon v-if="post.data.user_picture === null" name="ri-user-3-line" class="w-8 h-8 text-base-100 mt-0.5"/>
                                        <img v-else :src="`/storage/${post.data.user_picture}`" alt="Profile Picture"/>
                                    </div>
                                </div>

                                <span class="text-base-content font-semibold">
                                    {{ post.data.username }}
                                </span>

                                <span class="text-base-content/50 ml-5">
                                    {{ post.data.created_at }}
                                </span>
                            </div>

                            <div v-if="$page.props.auth.auth_check">
                                <Link v-if="can_update" :href="route('communities.posts.edit', [community.slug, post.data.slug])" class="btn btn-warning btn-sm uppercase mr-2" method="get" type="button">
                                    {{ $t('edit') }}
                                </Link>

                                <Link v-if="can_delete" :href="route('communities.posts.destroy', [community.slug, post.data.slug])" class="btn btn-error btn-sm uppercase" method="delete" type="button">
                                    {{ $t('delete') }}
                                </Link>
                            </div>
                        </div>

                        <div class="p-2">
                            <h1 class="font-semibold text-3xl">
                                {{ post.data.title }}
                            </h1>

                            <p class="my-2 text-base">
                                {{ post.data.description }}
                            </p>

                            <a :href="post.data.url" class="btn-link hover:text-accent">
                                {{ post.data.url }}
                            </a>

                            <div v-if="post.data.files.length" class="m-4">
                                <div v-for="file in post.data.files" :key="file.id">
                                    <div v-if="file.mime_type.startsWith('image')">
                                        <img :src="file.url" class="rounded-selector max-w-full h-auto"/>
                                    </div>

                                    <div v-else-if="file.mime_type.startsWith('video')">
                                        <video controls class="rounded-selector max-w-full h-auto">
                                            <source :src="file.url" :type="file.mime_type">
                                        </video>
                                    </div>

                                    <div v-else-if="file.mime_type.startsWith('audio')">
                                        <audio controls class="rounded-selector w-full">
                                            <source :src="file.url" :type="file.mime_type">
                                        </audio>
                                    </div>

                                    <div class="mt-2 flex justify-between">
                                        <div class="text-sm text-base-content/70">
                                            {{ file.formatted_size }}
                                        </div>

                                        <div>
                                            <a :href="route('download', file.id)" class="btn btn-circle mr-2 hover:text-success">
                                                <v-icon name="hi-download"/>
                                            </a>

                                            <button class="btn btn-circle hover:text-info" @click="copyLink">
                                                <v-icon name="fa-share"/>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="flex justify-end">
                                <button class="btn btn-circle hover:text-info" @click="copyLink">
                                    <v-icon name="fa-share"/>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<!--            <div class="w-full md:w-4/12 p-4">-->
<!--                <CommunityList class="mt-4" :community="community">-->
<!--                    <template #title>Latest Communities</template>-->
<!--                </CommunityList>-->
<!--            </div>-->

            <div class="w-full md:w-8/12 my-5">
                <div v-if="$page.props.auth.auth_check" class="ml-3">
                    <form class="max-w-md" @submit.prevent="submit">
                        <div class="flex items-end">
                            <div class="flex-grow">
                                <textarea v-model="form.content" id="comment" rows="3"  :placeholder="$t('your comment')+'...'"
                                          class="block p-2 w-full text-sm rounded-selector bg-base-300 resize-none border border-accent shadow-md shadow-accent">
                                </textarea>
                            </div>

                            <div class="ml-3 my-auto">
                                <button class="btn btn-accent shadow-md shadow-accent uppercase">
                                    {{ $t('comment') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <CommentSection :post :community="community.slug" :key="post.id" :comments />

            </div>
        </section>
    </LayoutPicker>
</template>
