<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import ErrorAlert from "@/Components/ErrorAlert.vue";
import {HiMail, MdKey} from "oh-vue-icons/icons";
import {addIcons} from "oh-vue-icons";
addIcons(HiMail, MdKey);


const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head :title="$t('reset password')" />

        <form @submit.prevent="submit" class="max-w-md mx-auto shadow-md rounded-box p-6 bg-base-100 border border-primary">
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

            <div class="mt-4">
                <label class="block font-medium text-sm" for="password">
                    {{ $t('password') }}
                </label>

                <label class="input input-secondary flex items-center gap-2">
                    <v-icon name="md-key" class="h-4 w-4 text-secondary"/>
                    <input id="password"
                           v-model="form.password"
                           type="password"
                           class="mt-1 block w-full"
                           autocomplete="new-password"
                           required
                           autofocus
                    />
                </label>

                <ErrorAlert class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <label class="block font-medium text-sm" for="password_confirmation">
                    {{ $t('confirm password') }}
                </label>

                <label class="input input-secondary flex items-center gap-2">
                    <v-icon name="md-key" class="h-4 w-4 text-secondary"/>
                    <input id="password_confirmation"
                           v-model="form.password_confirmation"
                           type="password"
                           class="mt-1 block w-full"
                           autocomplete="new-password"
                           required
                           autofocus
                    />
                </label>

                <ErrorAlert class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button class="btn btn-warning uppercase" :disabled="form.processing">
                    {{ $t('reset password') }}
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
