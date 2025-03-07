<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ErrorAlert from "@/Components/ErrorAlert.vue";
import {HiMail, MdKey} from "oh-vue-icons/icons";
import {addIcons} from "oh-vue-icons";
addIcons(HiMail, MdKey);

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="max-w-md mx-auto shadow-md rounded-xl p-6 bg-base-100 border border-primary">

            <div>
                <label class="block font-medium text-sm" for="email">Email</label>

                <label class="input input-bordered flex items-center gap-2 ">
                    <v-icon name="hi-mail" class="h-4 w-4 opacity-70"/>
                    <input id="email"
                           type="email"
                           class="mt-1 w-full grow"
                           v-model="form.email"
                           required
                           autocomplete="username"
                    />
                </label>

                <ErrorAlert class="mt-2" :message="form.errors.email"/>
            </div>

            <div class="mt-4">
                <label class="block font-medium text-sm" for="password">Password</label>

                <label class="input input-bordered flex items-center gap-2">
                    <v-icon name="md-key" class="h-4 w-4 opacity-70"/>
                    <input id="password"
                           required
                           v-model="form.password"
                           type="password"
                           class="mt-1 w-full grow"
                           autocomplete="current-password"
                    />
                </label>

                <ErrorAlert class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="cursor-pointer label flex items-center">
                    <span class="label-text">
                        Remember me
                    </span>
                    <input type="checkbox" class="checkbox checkbox-sm checkbox-secondary" v-model="form.remember"/>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')" class="text-sm btn-link hover:text-secondary">
                    Forgot your password?
                </Link>

                <button class="ms-4 btn btn-success" :disabled="form.processing">
                    Log In
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
