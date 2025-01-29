<script setup>
import AuthLayout from "@/Layouts/AuthLayout.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";

</script>

<template>
    <component :is="$page.props.auth.auth_check ? AuthLayout : GuestLayout">
        <slot/>
    </component>
</template>
