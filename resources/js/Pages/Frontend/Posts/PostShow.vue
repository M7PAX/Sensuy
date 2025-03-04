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
        route('frontend.posts.comments', [props.community.slug, props.post.data.slug]),{
            onSuccess: () => form.reset('content')
        }
    );
};
</script>

<template>
    <LayoutPicker>
        <template #header>
            <div class="flex justify-between">
                <Link :href="route('frontend.communities.show', community.slug)" class="font-semibold text-xl leading-tight btn-link no-underline hover:text-primary">
                    s/{{ community.name }}
                </Link>
            </div>
        </template>

        <section class="flex flex-colm-2 p-2 md:flex-row">
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
                                <button v-if="can_update" class="btn btn-warning inline-flex items-center font-semibold text-xs uppercase tracking-widest px-4 py-2">
                                    <Link :href="route('communities.posts.edit', [community.slug, post.data.slug])" method="get" type="button">
                                        Edit
                                    </Link>
                                </button>
                                <button v-if="can_delete" class="btn btn-error inline-flex items-center font-semibold text-xs uppercase px-4 py-2 ml-3">
                                    <Link :href="route('communities.posts.destroy', [community.slug, post.data.slug])" method="delete" type="button">
                                        Delete
                                    </Link>
                                </button>
                            </div>
                        </div>
                        <div class="p-2">
                            <h1 class="font-semibold text-3xl">
                                {{ post.data.title }}
                            </h1>
                            <p class="my-2 text-base">
                                {{ post.data.description }}
                            </p>
                            <a :href="post.data.url" class="font-semibold btn-link">
                                {{ post.data.url }}
                            </a>
                        </div>
                        <div v-if="$page.props.auth.auth_check">
                            <form class="m-1 p-1 max-w-md" @submit.prevent="submit">
                                <div class="mt-2">
                                    <textarea v-model="form.content" id="comment" rows="2"  placeholder="Your comment..."
                                              class="block p-2.5 w-full text-sm rounded-xl bg-base-300">
                                    </textarea>
                                </div>
                                <div class="mt-2">
                                    <button class="btn btn-primary px-4 py-2">
                                        Comment
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div>
                            <ul role="list" class="divide-y m-2 p-2">
                                <li v-for="(comment, index) in post.data.comments" :key="index" class="py-4 flex flex-col">
                                    <div class="text-sm text-base-content/50">
                                        <span class="ml-5">
                                            Commented by
                                        </span>
                                        <span class="font-semibold text-base-content">
                                            {{ comment.username }}
                                        </span>
                                    </div>
                                    <div class="m-1 p-1 ml-8">
                                        {{ comment.content }}
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
<!--            <div class="w-full md:w-4/12 p-4">-->
<!--                <CommunityList class="mt-4" :community="community">-->
<!--                    <template #title>Latest Communities</template>-->
<!--                </CommunityList>-->
<!--            </div>-->

        </section>
    </LayoutPicker>
</template>
