<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import ErrorAlert from "@/Components/ErrorAlert.vue";
import LayoutPicker from "@/Components/LayoutPicker.vue";

const props = defineProps({
    community: Object,
    post: Object,
    comment: Object,
})

const form = useForm({
    content: props.comment?.content
});

const submit = () => {
    form.put(route('communities.posts.comments.update', [props.community.slug, props.post.slug, props.comment.id]));
};
</script>

<template>
    <Head :title="$t('edit comment')" />

    <LayoutPicker>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">
                {{ $t('edit comment for') }}
            </h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full sm:max-w-md mx-auto shadow-md overflow-hidden rounded-box bg-base-100 p-6 border border-primary">
                <form @submit.prevent="submit">
                    <div>
                        <label class="block font-medium text-sm" for="title">
                            {{ $t('comment') }}
                        </label>

                        <label class="flex items-center gap-2 w-full">
                            <textarea id="description"
                                      type="text"
                                      rows="3"
                                      class="textarea textarea-secondary w-full"
                                      v-model="form.content"
                                      required
                                      autofocus
                                      autocomplete="content">
                            </textarea>
                        </label>


                        <ErrorAlert class="mt-2" :message="form.errors.content"/>
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
