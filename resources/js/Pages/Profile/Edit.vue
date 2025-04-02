<script setup>
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import LayoutPicker from "@/Components/LayoutPicker.vue";

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

    <LayoutPicker>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">Profile</h2>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-5">
            <div class="p-4 sm:p-8 shadow-md border border-primary rounded-xl bg-base-100">
                <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status"/>
            </div>
            <div class="p-4 sm:p-8 shadow-md border border-primary rounded-xl bg-base-100">
                <UpdatePasswordForm />
            </div>
            <div class="p-4 sm:p-8 shadow-md border border-error rounded-xl bg-base-100">
                <DeleteUserForm />
            </div>
        </div>
    </LayoutPicker>
</template>
