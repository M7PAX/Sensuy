<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import ErrorAlert from "@/Components/ErrorAlert.vue";

const form = useForm({
    name: '',
    description: '',
    slug: ''
});

const submit = () => {
    form.post(route('communities.store'));
};
</script>

<template>
    <Head title="Create Community" />

    <AuthLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Community</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full sm:max-w-md mx-auto m-2 p-2 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="mt-4">
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="name">Name</label>
                            <label class="input input-bordered flex items-center gap-2 bg-gray-100 dark:bg-gray-900 text-black dark:text-white">
                                <input id="name"
                                       type="text"
                                       class="mt-1 block w-full"
                                       v-model="form.name"
                                       required
                                       autofocus
                                       autocomplete="name"
                                />
                            </label>
                            <ErrorAlert class="mt-2" :message="form.errors.name"/>
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

                        <div class="flex items-center justify-end mt-4">
                            <button class="btn btn-success text-white dark:text-black ms-4" :disabled="form.processing">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>
