<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import ErrorAlert from "@/Components/ErrorAlert.vue";
import {ref} from "vue";
import {HiMail, RiUser3Line} from "oh-vue-icons/icons";
import {addIcons} from "oh-vue-icons";
addIcons(RiUser3Line, HiMail);

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;
const previewImage = ref(null);

const form = useForm({
    username: user.username,
    email: user.email,
    picture: null,
});

const handleFileInput = (event) => {
    const file = event.target.files[0];
    form.picture = file;

    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.value = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        previewImage.value = null;
    }
};

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium">
                {{ $t('profile info') }}
            </h2>

            <p class="mt-1 text-sm">
                {{ $t('profile info text') }}
            </p>
        </header>

        <form @submit.prevent="form.post(route('profile.update'), { method: 'put' })" class="mt-6">
            <div class="flex justify-between">
                <div class="flex-1 space-y-6">
                    <div class="form-control">
                        <label class="block font-medium text-sm" for="name">
                            {{ $t('username') }}
                        </label>

                        <label class="input input-secondary flex items-center gap-2">
                            <v-icon name="ri-user-3-line" class="h-4 w-4 text-secondary"/>

                            <input id="name"
                                   type="text"
                                   class="mt-1 block w-full"
                                   v-model="form.username"
                                   required
                                   autofocus
                                   autocomplete="name"
                            />
                        </label>

                        <ErrorAlert class="mt-2" :message="form.errors.username"/>
                    </div>

                    <div>
                        <label class="block font-medium text-sm" for="email">
                            {{ $t('email') }}
                        </label>

                        <label class="input input-secondary flex items-center gap-2">
                            <v-icon name="hi-mail" class="h-4 w-4 text-secondary"/>
                            <input id="email"
                                   type="email"
                                   class="mt-1 block w-full"
                                   v-model="form.email"
                                   required
                                   autocomplete="email"
                            />
                        </label>

                        <ErrorAlert class="mt-2" :message="form.errors.email"/>
                    </div>
                </div>

                <div class="flex-1 space-y-4">
                    <div class="flex justify-center ">
                        <label for="picture" class=" w-42 h-42">
                            <div class="avatar">
                                <div :class="['mask', 'bg-accent', user.is_admin ? 'mask-hexagon' : 'mask-hexagon-2']">
                                    <img v-if="previewImage" :src="previewImage" alt="Preview" class="w-40 h-40 mt-1 object-cover"/>
                                    <img v-else-if="user.picture" :src="`/storage/${user.picture}`" alt="Current profile picture" class="w-40 h-40 object-cover"/>
                                    <v-icon v-else name="ri-user-3-line" class="w-40 h-40 mt-1 text-base-100"/>
                                </div>
                            </div>

                            <div class="flex justify-center">
                                <label class="font-medium text-sm justify-center">
                                    {{ $t('profile picture') }}
                                </label>
                            </div>

                            <fieldset class="fieldset" hidden>
                                <input id="picture"
                                       type="file"
                                       class="file-input"
                                       @input="handleFileInput"
                                       accept="image/*"
                                />
                            </fieldset>

                            <ErrorAlert class="mt-2" :message="form.errors.picture"/>
                        </label>
                    </div>
                </div>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2">
                    {{ $t('profile info text 1') }}

                    <Link :href="route('verification.send')" method="post" class="underline text-sm btn-link">
                        {{ $t('profile info text 2') }}
                    </Link>
                </p>

                <div v-show="status === 'verification-link-sent'" class="mt-2 font-medium text-sm text-success">
                    {{ $t('profile info text 3') }}
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button class="btn btn-success uppercase" :disabled="form.processing">
                    {{ $t('save') }}
                </button>
            </div>
        </form>
    </section>
</template>
