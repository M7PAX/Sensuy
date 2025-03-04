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
        <Head title="Reset Password" />

        <form @submit.prevent="submit">
            <div>
                <label class="block font-medium text-sm" for="email">Email</label>

                <label class="input input-bordered flex items-center gap-2">
                    <v-icon name="hi-mail" class="h-4 w-4 opacity-70"/>
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
                <label class="block font-medium text-sm" for="password">Password</label>

                <label class="input input-bordered flex items-center gap-2">
                    <v-icon name="md-key" class="h-4 w-4 opacity-70"/>
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
                <label class="block font-medium text-sm" for="password_confirmation">Confirm Password</label>

                <label class="input input-bordered flex items-center gap-2">
                    <v-icon name="md-key" class="h-4 w-4 opacity-70"/>
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
                <button class="btn btn-warning" :disabled="form.processing">Reset Password</button>
            </div>
        </form>
    </GuestLayout>
</template>
