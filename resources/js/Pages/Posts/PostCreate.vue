<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from "vue";
import ErrorAlert from "@/Components/ErrorAlert.vue";
import LayoutPicker from "@/Components/LayoutPicker.vue";
import AIChat from "@/Components/AIChat.vue";

const props = defineProps({
    community: Object,
});

const form = useForm({
    title: '',
    description: '',
    url: '',
    file: null,
    file_name: '',
});

const PreviewUrl = ref(null);

const submit = () => {
    form.post(route('communities.posts.store', props.community.slug), {
        forceFormData: true,
    });
};

const FileUpload = (file) => {
    if (file && !['image', 'video', 'audio'].includes(file.type.split('/')[0])) {
        form.setError('file', 'Only images, videos, and music files are allowed');
        return;
    }
    form.file = file;
    form.file_name = file ? file.name : '';
    PreviewUrl.value = file ? URL.createObjectURL(file) : null;
};

const handleAiError = (errorMessage) => {
    form.setError('title', errorMessage);
    form.setError('description', errorMessage);
};

</script>

<template>
    <Head :title="$t('create post')" />

    <LayoutPicker>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">
                {{ $t('create post for') }} {{ community.name }}
            </h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full sm:max-w-md mx-auto shadow-md overflow-hidden rounded-box bg-base-100 p-6 border border-primary">
                <form @submit.prevent="submit">
                    <div>
                        <label class="block font-medium text-sm" for="title">
                            {{ $t('title') }}
                        </label>

                        <label class="input input-secondary flex items-center gap-2 w-full">
                            <input id="title"
                                   type="text"
                                   class="mt-1"
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
                            {{ $t('description') }}
                        </label>

                        <label class="flex items-center gap-2">
                            <textarea id="description"
                                      type="text"
                                      rows="3"
                                      class="textarea textarea-secondary w-full"
                                      v-model="form.description"
                                      autocomplete="description">
                            </textarea>
                        </label>

                        <ErrorAlert class="mt-2" :message="form.errors.description"/>
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium text-sm" for="url">
                            {{ $t('link') }}
                        </label>

                        <label class="input input-secondary flex items-center gap-2 w-full">
                            <input id="url"
                                   type="text"
                                   class="mt-1"
                                   v-model="form.url"
                                   autofocus
                                   autocomplete="url"
                            />
                        </label>

                        <ErrorAlert class="mt-2" :message="form.errors.url"/>
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium text-sm" for="file_name">
                            {{ $t('file name') }}
                        </label>

                        <label class="input input-secondary flex items-center gap-2 w-full">
                            <input id="file_name"
                                   type="text"
                                   class="mt-1"
                                   v-model="form.file_name"
                                   autofocus
                                   autocomplete="file_name"
                            />
                        </label>

                        <ErrorAlert class="mt-2" :message="form.errors.file_name"/>
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium text-sm">
                            {{ $t('file') }}
                        </label>

                        <fieldset class="fieldset">
                            <input type="file"
                                   class="file-input file-input-accent w-full"
                                   accept="image/*,video/*,audio/*"
                                   @input="FileUpload($event.target.files[0])"
                            />

                            <label class="fieldset-label">
                                {{ $t('file post') }}
                            </label>
                        </fieldset>

                        <ErrorAlert class="mt-2" :message="form.errors.file"/>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <AIChat v-model:title="form.title"
                            v-model:description="form.description"
                            @error="handleAiError"
                        />

                        <button class="ms-4 btn btn-success uppercase" :disabled="form.processing">
                            {{ $t('create') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </LayoutPicker>
</template>
