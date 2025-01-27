<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import ErrorAlert from "@/Components/ErrorAlert.vue";
import { MdKey } from "oh-vue-icons/icons";
import { addIcons } from "oh-vue-icons";
addIcons(MdKey);

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Confirm Password" />

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            This is a secure area of the application. Please confirm your password before continuing.
        </div>

        <form @submit.prevent="submit">
            <div>
                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300" for="password">Password</label>

                <label class="input input-bordered flex items-center gap-2 bg-gray-100 dark:bg-gray-900 text-black dark:text-white">
                    <v-icon name="md-key" class="h-4 w-4 opacity-70 text-black dark:text-white"/>
                    <input id="password"
                           v-model="form.password"
                           type="password"
                           class="mt-1 block w-full"
                           autocomplete="current-password"
                           required
                           autofocus
                    />
                </label>

                <ErrorAlert class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex justify-end mt-4">
                <button class="btn btn-success text-white dark:text-black ms-4" :disabled="form.processing">Confirm</button>
            </div>
        </form>
    </GuestLayout>
</template>
