<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import ErrorAlert from "@/Components/ErrorAlert.vue";

const props = defineProps({
    community: Object,
})

const form = useForm({
    title: '',
    description: '',
    url: ''
});

const submit = () => {
    form.post(route('communities.posts.store', props.community.slug));
};
</script>

<template>
    <Head title="Create Community" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Post for {{community.name}}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full sm:max-w-md mx-auto m-2 p-2 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="mt-4">
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="title">Title</label>

                            <label class="input input-bordered flex items-center gap-2 bg-gray-100 dark:bg-gray-900 text-black dark:text-white">
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
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="description">Description</label>

                            <label class="input input-bordered flex items-center gap-2 bg-gray-100 dark:bg-gray-900 text-black dark:text-white">
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

                        <div class="mt-4">
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="url">URL</label>

                            <label class="input input-bordered flex items-center gap-2 bg-gray-100 dark:bg-gray-900 text-black dark:text-white">
                                <input id="url"
                                       type="text"
                                       class="mt-1 block w-full"
                                       v-model="form.url"
                                       autofocus
                                       autocomplete="url"
                                />
                            </label>

                            <ErrorAlert class="mt-2" :message="form.errors.url"/>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button class="ms-4 btn btn-success text-white dark:text-black" :disabled="form.processing">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
