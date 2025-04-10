<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>
        <Head :title="$t('email verification')" />

        <div class="mb-4 text-sm">
            {{ $t('email verification text 1') }}
        </div>
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400" v-if="verificationLinkSent">
            {{ $t('email verification text 2') }}
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <button class="btn btn-warning uppercase" :disabled="form.processing">
                    {{ $t('resend verification') }}
                </button>

                <Link :href="route('logout')" method="post" as="button" class="underline text-sm">
                    {{ $t('logout') }}
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
