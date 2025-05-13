<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import ErrorAlert from "@/Components/ErrorAlert.vue";
import {HiMail} from "oh-vue-icons/icons";
import {addIcons} from "oh-vue-icons";
addIcons(HiMail);

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head :title="$t('forgot password')" />

        <form @submit.prevent="submit" class="max-w-md mx-auto shadow-md rounded-box p-6 bg-base-100 border border-primary">
            <div class="mb-4 text-sm">
                {{ $t('forgot password text') }}
            </div>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ status }}
            </div>

            <div>
                <label class="block font-medium text-sm" for="email">
                    {{ $t('email') }}
                </label>

                <label class="input input-secondary flex items-center gap-2">
                    <v-icon name="hi-mail" class="h-4 w-4 text-secondary"/>
                    <input id="email"
                           type="email"
                           class="mt-1 block w-full"
                           v-model="form.email"
                           required
                           autocomplete="username"
                           autofocus
                    />
                </label>

                <ErrorAlert class="mt-2" :message="form.errors.email"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <button class="btn btn-warning ms-4 uppercase" :disabled="form.processing">
                    {{ $t('reset link') }}
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
