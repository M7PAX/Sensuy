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
        <Head :title="$t('confirm password')" />

        <div class="mb-4 text-sm">
            {{ $t('confirm password text') }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <label class="block font-medium text-sm" for="password">
                    {{ $t('password') }}
                </label>
                <label class="input input-bordered border border-secondary flex items-center gap-2">
                    <v-icon name="md-key" class="h-4 w-4 opacity-70"/>
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
                <button class="btn btn-success ms-4 uppercase" :disabled="form.processing">
                    {{ $t('confirm') }}
                </button>
            </div>
        </form>
    </GuestLayout>
</template>
