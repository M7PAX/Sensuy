<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import ErrorAlert from "@/Components/ErrorAlert.vue";
import LayoutPicker from "@/Components/LayoutPicker.vue";

const form = useForm({
    name: '',
    description: '',
    slug: ''
});

const pictureInput = ref(null);
const backgroundInput = ref(null);

const submit = () => {
    const formData = new FormData();
    formData.append('name', form.name);
    formData.append('description', form.description);
    formData.append('slug', form.slug);

    if (pictureInput.value?.files[0]) {
        formData.append('picture', pictureInput.value.files[0]);
    }
    if (backgroundInput.value?.files[0]) {
        formData.append('background', backgroundInput.value.files[0]);
    }

    router.post(route('communities.store'), formData, {
        onSuccess: () => form.reset(),
        onError: (errors) => Object.assign(form.errors, errors),
    });
};
</script>

<template>
    <Head :title="$t('create community')" />

    <LayoutPicker>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">
                {{ $t('create community') }}
            </h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full sm:max-w-md mx-auto shadow-md overflow-hidden rounded-box bg-base-100 p-6 border border-primary">
                <form @submit.prevent="submit">
                    <div>
                        <label class="block font-medium text-sm" for="name">
                            {{ $t('name') }}
                        </label>

                        <label class="input input-secondary flex items-center gap-2">
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
                            {{ $t('description') }}
                        </label>

                        <label class="input input-secondary flex items-center gap-2">
                            <input id="description"
                                   type="text"
                                   class="mt-1 block w-full"
                                   v-model="form.description"
                                   autocomplete="description"
                            />
                        </label>

                        <ErrorAlert class="mt-2" :message="form.errors.description"/>
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium text-sm">
                            {{ $t('community icon') }}
                        </label>

                        <fieldset class="fieldset">
                            <input type="file"
                                ref="pictureInput"
                                class="file-input file-input-accent"
                                accept="image/*"
                            />

                            <label class="fieldset-label">
                                {{ $t('file community') }}
                            </label>
                        </fieldset>

                        <ErrorAlert class="mt-2" :message="form.errors.picture"/>
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium text-sm">
                            {{ $t('community background') }}
                        </label>

                        <fieldset class="fieldset">
                            <input
                                type="file"
                                ref="backgroundInput"
                                class="file-input file-input-accent"
                                accept="image/*"
                            />

                            <label class="fieldset-label">
                                {{ $t('file community') }}
                            </label>
                        </fieldset>

                        <ErrorAlert class="mt-2" :message="form.errors.background"/>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button class="btn btn-success ms-4 uppercase" :disabled="form.processing">
                            {{ $t('create') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </LayoutPicker>
</template>
