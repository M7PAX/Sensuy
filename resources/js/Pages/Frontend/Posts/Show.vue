<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import PostVote from "@/Components/PostVote.vue";
import CommunityList from "@/Components/CommunityList.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    community: Object,
    post: Object,
    can_update: Boolean,
    can_delete: Boolean,
});

const form = useForm({
    content: ""
});

const submit = () => {
    form.post(
        route('frontend.posts.comments', [props.community.slug, props.post.data.slug]),{
            onSuccess: () => form.reset('content')
        }
    );
};
</script>

<template>
    <guest-layout>
        <template #header>
            <div class="flex justify-between">
                <Link :href="route('frontend.communities.show', community.slug)" class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    s/{{ community.name }}
                </Link>
            </div>
        </template>

        <section class="flex flex-colm-2 p-2 md:flex-row">
            <div class="w-full md:w-8/12 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 shadow-md">
                <div class="flex m-2 text-sm text-slate-400">
                    <div>
                        <PostVote :post="post.data"/>
                    </div>
                    <div class="w-full">
                        <div class="flex flex-col md:flex-row justify-between m-2">
                            <div class="text-sm">
                                Posted by
                                <span class="font-semibold text-black dark:text-white">
                                    {{ post.data.username }}
                                </span>
                                <span class="ml-5">
                                    {{ post.data.created_at }}
                                </span>
                            </div>
                            <div v-if="$page.props.auth.auth_check">
                                <Link v-if="can_update" class="inline-flex items-center font-semibold text-xs text-white uppercase tracking-widest bg-yellow-500 hover:bg-yellow-700 rounded-md px-4 py-2"
                                      :href="route('communities.posts.edit', [community.slug, post.data.slug])">
                                    Edit
                                </Link>
                                <Link v-if="can_delete" class="inline-flex items-center font-semibold text-xs text-white uppercase tracking-widest bg-red-500 hover:bg-red-700 ml-2 rounded-md px-4 py-2"
                                      :href="route('communities.posts.destroy', [community.slug, post.data.slug])"
                                      method="delete" as="button" type="button">
                                    Delete
                                </Link>
                            </div>
                        </div>
                        <div class="p-2">
                            <h1 class="font-semibold text-3xl text-gray-900 dark:text-gray-100">
                                {{ post.data.title }}
                            </h1>
                            <p class="my-2 text-base text-gray-600 dark:text-gray-400">
                                {{ post.data.description }}
                            </p>
                            <a :href="post.data.url" class="font-semibold text-blue-500 text-sm hover:text-blue-300">
                                {{ post.data.url }}
                            </a>
                        </div>
                        <div v-if="$page.props.auth.auth_check">
                            <form class="m-1 p-1 max-w-md" @submit.prevent="submit">
                                <div class="mt-2">
                                    <textarea v-model="form.content" id="comment" rows="2"  placeholder="Your comment..."
                                              class="block p-2.5 w-full text-sm rounded-lg text-black dark:text-white bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600">
                                    </textarea>
                                </div>
                                <div class="mt-2">
                                    <PrimaryButton class="px-4 py-2">
                                        Comment
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                        <div>
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-600 m-2 p-2">
                                <li v-for="(comment, index) in post.data.comments" :key="index" class="py-4 flex flex-col">
                                    <div class="text-sm">
                                        <span class="ml-5 text-gray-800 dark:text-gray-200">
                                            Commented by
                                        </span>
                                        <span class="font-semibold text-black dark:text-white">
                                            {{ comment.username }}
                                        </span>
                                    </div>
                                    <div class="text-gray-500 m-1 p-1 ml-8">
                                        {{ comment.content }}
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-4/12 p-4">
                <CommunityList class="mt-4" :community="community">
                    <template #title>Latest Communities</template>
                </CommunityList>
            </div>

        </section>
    </guest-layout>
</template>
