<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import ErrorAlert from "@/Components/ErrorAlert.vue";
import { MdKey } from "oh-vue-icons/icons";
import { addIcons } from "oh-vue-icons";
addIcons(MdKey);

const passwordInput = ref(null);
const modalRef = ref(null);

const form = useForm({
    password: '',
});

const toggleModal = (action) => {
    if (modalRef.value) {
        if (action === "open") {
            modalRef.value.showModal();
        } else {
            modalRef.value.close();
        }
    }
}

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => toggleModal('close'),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium">
                {{ $t('delete acc') }}
            </h2>

            <p class="mt-1 text-sm">
                {{ $t('delete acc text 1') }}
            </p>
        </header>

        <button class="btn btn-error uppercase" @click="toggleModal('open')">
            {{ $t('delete acc') }}
        </button>

        <dialog ref="modalRef" class="modal">
            <div class="modal-box p-6">
                <h2 class="text-lg font-medium">
                    {{ $t('delete acc text 2') }}
                </h2>

                <p class="mt-1 text-sm">
                    {{ $t('delete acc text 3') }}
                </p>

                <div class="mt-6">
                    <label class="block font-medium text-sm" for="password">
                        {{ $t('password') }}
                    </label>

                    <label class="input input-error flex items-center gap-2 text-error">
                        <v-icon name="md-key" class="h-4 w-4 text-error"/>

                        <input id="password"
                               ref="passwordInput"
                               v-model="form.password"
                               type="password"
                               class="mt-1 block w-3/4"
                               placeholder="Password"
                               @keyup.enter="deleteUser"
                        />
                    </label>

                    <ErrorAlert class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="button" @click="toggleModal('close')" class="btn uppercase">
                        {{ $t('cancel') }}
                    </button>

                    <button type="button" class="btn btn-error ms-3 uppercase" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteUser">
                        {{ $t('delete acc') }}
                    </button>
                </div>
            </div>
        </dialog>
    </section>
</template>
