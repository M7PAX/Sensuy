<script setup>
import { watch, onMounted, computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { useForm, usePage } from '@inertiajs/vue3';

const { t, locale } = useI18n();
const user = usePage().props.auth.user;

const form = useForm({
    theme: user?.theme || localStorage.getItem('user-theme') || 'dark',
    language: user?.language || localStorage.getItem('user-locale') || 'EN',
});

const availableLanguages = computed(() => [
    { code: 'EN', label: t('english') },
    { code: 'LV', label: t('latvian') },
    { code: 'RU', label: t('russian') },
]);

const availableThemes = [
    'dark', 'light', 'cupcake', 'bumblebee', 'emerald',
    'corporate', 'synthwave', 'retro', 'cyberpunk',
    'valentine', 'halloween', 'garden', 'forest',
    'aqua', 'lofi', 'pastel', 'fantasy', 'wireframe',
    'black', 'luxury', 'dracula', 'cmyk', 'autumn',
    'business', 'acid', 'lemonade', 'night', 'coffee',
    'winter', 'dim', 'nord', 'sunset', 'caramellatte',
    'abyss', 'silk'
];

const submit = () => {
    form.patch(route('settings.update'), {
        onSuccess: () => {
            localStorage.setItem('user-theme', form.theme);
            localStorage.setItem('user-locale', form.language);
        },
    });
};

onMounted(() => {
    const initialLocale = form.language;
    locale.value = initialLocale;
    document.documentElement.setAttribute('lang', initialLocale);
    document.documentElement.setAttribute('data-theme', form.theme);
});

watch(() => form.language, async (newLocale) => {
    locale.value = newLocale;
    localStorage.setItem('user-locale', newLocale);
    document.documentElement.setAttribute('lang', newLocale);
});

watch(() => form.theme, (newTheme) => {
    document.documentElement.setAttribute('data-theme', newTheme);
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium">
                {{ $t('user settings') }}
            </h2>

            <p class="mt-1 text-sm">
                {{ $t('user settings text') }}
            </p>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div>
                <label class="block font-medium text-sm">
                    {{ $t('themes') }}:
                </label>

                <div class="filter">
                    <input type="radio" name="theme" class="btn my-1 filter-reset"/>

                    <input v-for="theme in availableThemes"
                           :key="theme"
                           type="radio"
                           name="theme"
                           class="btn theme-controller capitalize my-1"
                           :aria-label="theme"
                           :value="theme"
                           v-model="form.theme"
                    />
                </div>
            </div>

            <div>
                <label class="block font-medium text-sm">
                    {{ $t('languages') }}:
                </label>

                <fieldset class="fieldset font-bold text-sm">
                    <label v-for="lang in availableLanguages" :key="lang.code" class="flex gap-2 cursor-pointer items-center">
                        <input type="radio"
                               name="language"
                               class="radio radio-secondary"
                               :value="lang.code"
                               v-model="form.language"
                        />

                        {{ lang.label }}
                    </label>
                </fieldset>
            </div>

            <div class="flex items-center gap-4">
                <button class="btn btn-success uppercase" :disabled="form.processing">
                    {{ $t('save') }}
                </button>
            </div>
        </form>
    </section>
</template>
