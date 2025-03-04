<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

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
    <Head title="Profile" />

    <AuthLayout>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Profile</h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 shadow-sm border border-primary rounded-xl bg-base-100">
                <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" class="max-w-xl"/>
            </div>

            <div class="p-4 sm:p-8 shadow-sm border border-primary rounded-xl bg-base-100">
                <UpdatePasswordForm class="max-w-xl"/>
            </div>

            <div class="p-4 sm:p-8 shadow-sm border border-primary rounded-xl bg-base-100">
                <DeleteUserForm class="max-w-xl"/>
            </div>
        </div>
    </AuthLayout>
</template>
