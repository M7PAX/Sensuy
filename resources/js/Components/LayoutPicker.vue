<script setup>
import AuthLayout from "@/Layouts/AuthLayout.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";

</script>

<template>
    <component :is="$page.props.auth.auth_check ? AuthLayout : GuestLayout">
        <template #header v-if="$slots.header">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </template>

        <slot />
    </component>
</template>
