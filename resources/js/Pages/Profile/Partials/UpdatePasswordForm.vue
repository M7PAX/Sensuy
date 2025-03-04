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
            <h2 class="text-lg font-medium">Update Password</h2>
            <p class="mt-1 text-sm">
                Ensure your account is using a long, random password to stay secure.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <div>
                <label class="block font-medium text-sm" for="current_password"> Current Password </label>

                <label class="input input-bordered flex items-center gap-2">
                    <v-icon name="md-key" class="h-4 w-4 opacity-70"/>
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
                <label class="block font-medium text-sm" for="password"> New Password </label>

                <label class="input input-bordered flex items-center gap-2">
                    <v-icon name="md-key" class="h-4 w-4 opacity-70"/>
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
                <label class="block font-medium text-sm" for="password_confirmation"> Confirm Password </label>

                <label class="input input-bordered flex items-center gap-2">
                    <v-icon name="md-key" class="h-4 w-4 opacity-70"/>
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
                <button class="btn btn-success" :disabled="form.processing">Save</button>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
