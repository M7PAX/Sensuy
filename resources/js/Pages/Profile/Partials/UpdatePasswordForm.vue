<script setup>
import { ref } from 'vue';
import ErrorAlert from "@/Components/ErrorAlert.vue";
import {useForm} from "@inertiajs/vue3";
import { MdKey } from "oh-vue-icons/icons";
import { addIcons } from "oh-vue-icons";
addIcons(MdKey);

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium">
                {{ $t('update password') }}
            </h2>

            <p class="mt-1 text-sm">
                {{ $t('update password text') }}
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <div>
                <label class="block font-medium text-sm" for="current_password">
                    {{ $t('current password') }}
                </label>

                <label class="input input-secondary flex items-center gap-2">
                    <v-icon name="md-key" class="h-4 w-4 text-secondary"/>

                    <input id="current_password"
                           ref="currentPasswordInput"
                           v-model="form.current_password"
                           type="password"
                           class="mt-1 block w-full"
                           autocomplete="current-password"
                    />
                </label>

                <ErrorAlert class="mt-2" :message="form.errors.current_password" />
            </div>

            <div>
                <label class="block font-medium text-sm" for="password">
                    {{ $t('new password') }}
                </label>

                <label class="input input-secondary flex items-center gap-2">
                    <v-icon name="md-key" class="h-4 w-4 text-secondary"/>

                    <input id="password"
                           ref="passwordInput"
                           v-model="form.password"
                           type="password"
                           class="mt-1 block w-full"
                           autocomplete="new-password"
                    />
                </label>

                <ErrorAlert class="mt-2" :message="form.errors.password" />
            </div>

            <div>
                <label class="block font-medium text-sm" for="password_confirmation">
                    {{ $t('confirm password') }}
                </label>

                <label class="input input-secondary flex items-center gap-2">
                    <v-icon name="md-key" class="h-4 w-4 text-secondary"/>

                    <input id="password_confirmation"
                           v-model="form.password_confirmation"
                           type="password"
                           class="mt-1 block w-full"
                           autocomplete="new-password"
                    />
                </label>

                <ErrorAlert class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center gap-4">
                <button class="btn btn-success uppercase" :disabled="form.processing">
                    {{ $t('save') }}
                </button>
            </div>
        </form>
    </section>
</template>
