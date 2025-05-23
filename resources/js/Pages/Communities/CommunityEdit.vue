<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import ErrorAlert from "@/Components/ErrorAlert.vue";
import LayoutPicker from "@/Components/LayoutPicker.vue";

const props = defineProps({
    community: Object,
})

const pictureInput = ref(null);
const backgroundInput = ref(null);

const form = useForm({
    description: props.community.description,
    picture: props.community.picture,
    background: props.community.background,
});

const submit = () => {
    const formData = new FormData();

    formData.append('description', form.description);

    if (pictureInput.value?.files[0]) {
        formData.append('picture', pictureInput.value.files[0]);
    }
    if (backgroundInput.value?.files[0]) {
        formData.append('background', backgroundInput.value.files[0]);
    }

    router.post(route('communities.update', [props.community.slug]), formData, {method: 'put'});
};

</script>

<template>
    <Head :title="$t('edit community')" />

    <LayoutPicker>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">
                {{ $t('edit community') }}
            </h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-3">
            <div class="w-full sm:max-w-md mx-auto shadow-md overflow-hidden rounded-box bg-base-100 p-6 border border-primary">
                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <label class="block font-medium text-sm" for="description">
                            {{ $t('description') }}
                        </label>

                        <label class="flex items-center gap-2 w-full">
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
                        <label class="block font-medium text-sm">
                            {{ $t('community icon') }}
                        </label>

                        <fieldset class="fieldset">
                            <input type="file"
                                ref="pictureInput"
                                class="file-input file-input-accent w-full"
                                accept="image/*"
                                @input="form.picture = $event.target.files[0]"
                            />

                            <label class="fieldset-label">
                                {{ $t('file community') }}
                            </label>
                        </fieldset>

                        <div v-if="community.picture" class="mt-2">
                            <label class="block text-xs">
                                {{ $t('current icon') }}
                            </label>

                            <div class="avatar">
                                <div class="mask mask-heart w-24 bg-primary">
                                    <img :src="`/storage/${community.picture}`"/>
                                </div>
                            </div>
                        </div>

                        <ErrorAlert class="mt-2" :message="form.errors.picture"/>
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium text-sm">
                            {{ $t('community background') }}
                        </label>

                        <fieldset class="fieldset">
                            <input type="file"
                                ref="backgroundInput"
                                class="file-input file-input-accent w-full"
                                accept="image/*"
                                @input="form.background = $event.target.files[0]"
                            />

                            <label class="fieldset-label">
                                {{ $t('file community') }}
                            </label>
                        </fieldset>

                        <div v-if="community.background" class="mt-2">
                            <label class="block text-xs">
                                {{ $t('current background') }}
                            </label>

                            <img :src="`/storage/${community.background}`" class="w-120 h-8 object-cover rounded-field">
                        </div>

                        <ErrorAlert class="mt-2" :message="form.errors.background"/>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button class="ms-4 btn btn-success uppercase" :disabled="form.processing">
                            {{ $t('update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </LayoutPicker>
</template>
