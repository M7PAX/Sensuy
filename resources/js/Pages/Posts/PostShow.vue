<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import PostVote from "@/Components/PostVote.vue";
import LayoutPicker from "@/Components/LayoutPicker.vue";

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
        route('comments', [props.community.slug, props.post.data.slug]),{
            onSuccess: () => form.reset('content')
        }
    );
};
</script>

<template>
    <LayoutPicker>
        <template #header>
            <div class="flex justify-between">
                <Link :href="route('communities', community.slug)" class="font-semibold text-xl leading-tight hover:text-secondary">
                    s/{{ community.name }}
                </Link>
            </div>
        </template>

        <section class="flex flex-col p-2">
            <div class="w-full md:w-8/12 rounded-xl border border-primary shadow-md bg-base-100">
                <div class="flex m-2 text-sm">
                    <div>
                        <PostVote :post="post.data"/>
                    </div>

                    <div class="w-full">
                        <div class="flex flex-col md:flex-row justify-between mx-2 mt-2">
                            <div class="text-sm text-base-content/50">
                                Posted by
                                <span class="font-semibold text-base-content">
                                    {{ post.data.username }}
                                </span>
                                <span class="ml-5">
                                    {{ post.data.created_at }}
                                </span>
                            </div>
                            <div v-if="$page.props.auth.auth_check">
                                <Link v-if="can_update" :href="route('communities.posts.edit', [community.slug, post.data.slug])" class="btn btn-warning btn-sm uppercase mr-2" method="get" type="button">
                                    Edit
                                </Link>
                                <Link v-if="can_delete" :href="route('communities.posts.destroy', [community.slug, post.data.slug])" class="btn btn-error btn-sm uppercase" method="delete" type="button">
                                    Delete
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

<!--                            <div v-if="post.data.files.length" class="ml-5 mt-4">-->
<!--                                <div v-for="file in post.data.files" :key="file.id" class="mb-4">-->
<!--                                    <div>-->
<!--                                        <a :href="file.url" target="_blank" class="font-semibold hover:underline">-->
<!--                                            {{ file.name }}-->
<!--                                        </a>-->
<!--                                        <div class="text-sm text-base-content/70">{{ file.formatted_size }}</div>-->
<!--                                    </div>-->
<!--                                </div>-->

<!--                                <div v-if="file.mime_type.startsWith('image')" class="mt-2">-->
<!--                                    <img :src="file.url" class="rounded-lg max-w-full h-auto"/>-->
<!--                                </div>-->
<!--                                <div v-else-if="file.mime_type.startsWith('video')" class="mt-2">-->
<!--                                    <video controls class="rounded-lg max-w-full h-auto">-->
<!--                                        <source :src="file.url" :type="file.mime_type">-->
<!--                                    </video>-->
<!--                                </div>-->
<!--                                <div v-else-if="file.mime_type.startsWith('audio')" class="mt-2">-->
<!--                                    <audio controls class="rounded-lg w-full">-->
<!--                                        <source :src="file.url" :type="file.mime_type">-->
<!--                                    </audio>-->
<!--                                </div>-->
<!--                            </div>-->
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
                                <textarea v-model="form.content" id="comment" rows="3"  placeholder="Your comment..." class="block p-2 w-full text-sm rounded-xl bg-base-300 resize-none border border-accent shadow-md shadow-accent"></textarea>
                            </div>
                            <div class="ml-3 my-auto">
                                <button class="btn btn-accent shadow-md shadow-accent uppercase">
                                    Comment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div v-if="post.data.comments === null" class="bg-base-100 rounded-xl border border-secondary shadow-md my-5">
                    <ul role="list" class="divide-y divide-secondary mx-5">
                        <li v-for="(comment, index) in post.data.comments" :key="index" class="py-4 flex flex-col">
                            <div class="text-sm text-base-content/50 ml-3">
                                <span>
                                    Commented by
                                </span>
                                <span class="font-semibold text-base-content">
                                    {{ comment.username }}
                                </span>
                            </div>

                            <div class="ml-5">
                                {{ comment.content }}
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </LayoutPicker>
</template>
