<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import ErrorAlert from "@/Components/ErrorAlert.vue";
import LayoutPicker from "@/Components/LayoutPicker.vue";

const props = defineProps({
    post: Object,
    community: Object,
})

const form = useForm({
    title: props.post?.title,
    description: props.post?.description,
    url: props.post?.url,
});

const submit = () => {
    form.put(route('communities.posts.update', [props.community.slug, props.post.slug]));
};
</script>

<template>
    <Head title="Create Community" />

    <LayoutPicker>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Create Post for {{community.name}}</h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full sm:max-w-md mx-auto shadow-md overflow-hidden rounded-xl bg-base-100 p-6 border border-primary">
                <form @submit.prevent="submit">
                    <div>
                        <label class="block font-medium text-sm" for="title">
                            Title
                        </label>
                        <label class="input input-bordered flex items-center gap-2">
                            <input id="title"
                                   type="text"
                                   class="mt-1 block w-full"
                                   v-model="form.title"
                                   required
                                   autofocus
                                   autocomplete="title"
                            />
                        </label>
                        <ErrorAlert class="mt-2" :message="form.errors.title"/>
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium text-sm" for="description">
                            Description
                        </label>
                        <label class="input input-bordered flex items-center gap-2">
                            <input id="description"
                                   type="text"
                                   class="mt-1 block w-full"
                                   v-model="form.description"
                                   required
                                   autocomplete="description"
                            />
                        </label>
                        <ErrorAlert class="mt-2" :message="form.errors.description"/>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button class="ms-4 btn btn-success" :disabled="form.processing">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </LayoutPicker>
</template>
