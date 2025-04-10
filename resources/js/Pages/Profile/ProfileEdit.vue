<script setup>
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import LayoutPicker from "@/Components/LayoutPicker.vue";
import UserSettings from "@/Pages/Profile/Partials/UserSettings.vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head :title="$t('profile')" />

    <LayoutPicker>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">
                {{ $t('profile') }}
            </h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-5">
            <div class="p-4 sm:p-8 shadow-md border border-primary bg-base-100 rounded-box">
                <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status"/>
            </div>

            <div class="p-4 sm:p-8 shadow-md border border-primary bg-base-100 rounded-box">
                <UserSettings />
            </div>

            <div class="p-4 sm:p-8 shadow-md border border-primary bg-base-100 rounded-box">
                <UpdatePasswordForm />
            </div>

            <div class="p-4 sm:p-8 shadow-md border border-error bg-base-100 rounded-box">
                <DeleteUserForm />
            </div>
        </div>
    </LayoutPicker>
</template>
