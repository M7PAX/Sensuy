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
        <Head title="Register" />
        <form @submit.prevent="submit" class="max-w-md mx-auto shadow rounded-md p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600">

            <div>
                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="username">Username</label>
                <label class="input input-bordered flex items-center gap-2 bg-gray-100 dark:bg-gray-900 text-black dark:text-white">
                    <v-icon name="ri-user-3-line" class="h-4 w-4 opacity-70 text-black dark:text-white"/>
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
                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="email">Email</label>

                <label class="input input-bordered flex items-center gap-2 bg-gray-100 dark:bg-gray-900 text-black dark:text-white">
                    <v-icon name="hi-mail" class="h-4 w-4 opacity-70 text-black dark:text-white"/>
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
                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="password">Password</label>

                <label class="input input-bordered flex items-center gap-2 bg-gray-100 dark:bg-gray-900 text-black dark:text-white">
                    <v-icon name="md-key" class="h-4 w-4 opacity-70 text-black dark:text-white"/>
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
                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="password_confirmation">Confirm Password</label>

                <label class="input input-bordered flex items-center gap-2 bg-gray-100 dark:bg-gray-900 text-black dark:text-white">
                    <v-icon name="md-key" class="h-4 w-4 opacity-70 text-black dark:text-white"/>
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
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    Already registered?
                </Link>

                <button class="ms-4 btn btn-info text-white dark:text-black" :disabled="form.processing">Register</button>
            </div>
        </form>
    </GuestLayout>
</template>
