<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import ErrorAlert from "@/Components/ErrorAlert.vue";
import LayoutPicker from "@/Components/LayoutPicker.vue";

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

    <LayoutPicker>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Create Community</h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full sm:max-w-md mx-auto shadow-md overflow-hidden rounded-xl bg-base-100 p-6 border border-primary">
                <form @submit.prevent="submit">
                    <div>
                        <label class="block font-medium text-sm" for="name">
                            Name
                        </label>
                        <label class="input input-bordered flex items-center gap-2">
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
                        <label class="block font-medium text-sm" for="description">
                            Description
                        </label>
                        <label class="input input-bordered flex items-center gap-2">
                            <input id="description"
                                   type="text"
                                   class="mt-1 block w-full"
                                   v-model="form.description"
                                   autocomplete="description"
                            />
                        </label>
                        <ErrorAlert class="mt-2" :message="form.errors.description"/>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button class="btn btn-success ms-4 uppercase" :disabled="form.processing">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </LayoutPicker>
</template>
