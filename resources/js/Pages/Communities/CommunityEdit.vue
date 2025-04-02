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
    slug: props.community.slug,
    picture: props.community.picture,
    background: props.community.background,
});

const submit = () => {
    const formData = new FormData();

    formData.append('description', form.description);
    formData.append('slug', form.slug);

    if (pictureInput.value?.files[0]) {
        formData.append('picture', pictureInput.value.files[0]);
    }
    if (backgroundInput.value?.files[0]) {
        formData.append('background', backgroundInput.value.files[0]);
    }

    router.put(route('communities.update', { community: props.community.slug }), formData, {
        onSuccess: () => form.reset(),
        onError: (errors) => Object.assign(form.errors, errors),
        preserveState: true,
    });
};

</script>

<template>
    <Head title="Edit Community" />

    <LayoutPicker>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">
                Edit Community
            </h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-3">
            <div class="w-full sm:max-w-md mx-auto shadow-md overflow-hidden rounded-xl bg-base-100 p-6 border border-primary">
                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <label class="block font-medium text-sm" for="description">
                            Description
                        </label>
                        <label class="input input-bordered border border-secondary flex items-center gap-2">
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
                        <label class="block font-medium text-sm">Community icon</label>
                        <fieldset class="fieldset">
                            <input
                                type="file"
                                ref="pictureInput"
                                class="file-input file-input-accent"
                                accept="image/*"
                                @input="form.picture = $event.target.files[0]"
                            />
                            <label class="fieldset-label">Max: 100MB - Only images</label>
                        </fieldset>


                        <div v-if="community.picture" class="mt-2">
                            <label class="block text-xs">Current picture:</label>
                            <img :src="`/storage/${community.picture}`" alt="Current icon" class="w-24 h-24 object-cover rounded">
                        </div>

                        <ErrorAlert class="mt-2" :message="form.errors.picture"/>
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium text-sm">Community background</label>
                        <fieldset class="fieldset">
                            <input
                                type="file"
                                ref="backgroundInput"
                                class="file-input file-input-accent"
                                accept="image/*"
                                @input="form.background = $event.target.files[0]"
                            />
                            <label class="fieldset-label">Max: 100MB - Only images</label>
                        </fieldset>

                        <div v-if="community.background" class="mt-2">
                            <label class="block text-xs">Current background:</label>
                            <img :src="`/storage/${community.background}`" alt="Current background" class="w-48 h-24 object-cover rounded">
                        </div>

                        <ErrorAlert class="mt-2" :message="form.errors.background"/>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button class="ms-4 btn btn-success uppercase" :disabled="form.processing">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </LayoutPicker>
</template>
