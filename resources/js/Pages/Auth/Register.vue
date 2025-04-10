<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ErrorAlert from "@/Components/ErrorAlert.vue";
import {RiUser3Line, HiMail, MdKey} from "oh-vue-icons/icons";
import {addIcons} from "oh-vue-icons";
addIcons(RiUser3Line, HiMail, MdKey);

const form = useForm({
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head :title="$t('register')" />

        <form @submit.prevent="submit" class="max-w-md mx-auto shadow-md rounded-box p-6 bg-base-100 border border-primary">

            <div>
                <label class="block font-medium text-sm" for="username">
                    {{ $t('username') }}
                </label>

                <label class="input input-bordered border border-secondary flex items-center gap-2">
                    <v-icon name="ri-user-3-line" class="h-4 w-4 opacity-70"/>
                    <input id="name"
                           type="text"
                           class="mt-1 block w-full"
                           v-model="form.username"
                           required
                           autofocus
                           autocomplete="username"
                    />
                </label>

                <ErrorAlert class="mt-2" :message="form.errors.username"/>
            </div>

            <div class="mt-4">
                <label class="block font-medium text-sm" for="email">
                    {{ $t('email') }}
                </label>

                <label class="input input-bordered border border-secondary flex items-center gap-2">
                    <v-icon name="hi-mail" class="h-4 w-4 opacity-70"/>
                    <input id="email"
                           type="email"
                           class="mt-1 block w-full"
                           v-model="form.email"
                           required
                           autocomplete="username"
                    />
                </label>

                <ErrorAlert class="mt-2" :message="form.errors.email"/>
            </div>

            <div class="mt-4">
                <label class="block font-medium text-sm" for="password">
                    {{ $t('password') }}
                </label>

                <label class="input input-bordered border border-secondary flex items-center gap-2">
                    <v-icon name="md-key" class="h-4 w-4 opacity-70"/>
                    <input id="password"
                           ref="password"
                           v-model="form.password"
                           type="password"
                           class="mt-1 block w-full"
                           autocomplete="new-password"
                    />
                </label>

                <ErrorAlert class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <label class="block font-medium text-sm" for="password_confirmation">
                    {{ $t('confirm password') }}
                </label>

                <label class="input input-bordered border border-secondary flex items-center gap-2">
                    <v-icon name="md-key" class="h-4 w-4 opacity-70"/>
                    <input id="password_confirmation"
                           v-model="form.password_confirmation"
                           type="password"
                           class="mt-1 block w-full"
                           autocomplete="new-password"
                    />
                </label>

                <ErrorAlert class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="text-sm btn-link hover:text-secondary">
                    {{ $t('already registered') }}
                </Link>

                <button class="ms-4 btn btn-success uppercase" :disabled="form.processing">
                    {{ $t('register') }}
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
