<script setup>
import {onMounted, ref, watch} from 'vue';
import Logo from '@/Components/Logo.vue';
import { Link } from '@inertiajs/vue3';
import ThemeToggle from "@/Components/ThemeToggle.vue";
import {useI18n} from "vue-i18n";

const showingNavigationDropdown = ref(false);

const { locale } = useI18n();

const selectedLanguage = ref(locale.value);

watch(selectedLanguage, (newLocale) => {
    locale.value = newLocale;
    localStorage.setItem('user-locale', newLocale);
    document.documentElement.setAttribute('lang', newLocale);
});

onMounted(() => {
    const savedLocale = localStorage.getItem('user-locale');
    if (savedLocale) {
        selectedLanguage.value = savedLocale;
        locale.value = savedLocale;
        document.documentElement.setAttribute('lang', savedLocale);
    }
});
</script>

<template>
    <div>
        <div class="min-h-screen bg-base-200">
            <nav class="bg-base-100 border-b border-primary shadow-md">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link href="/">
                                    <Logo class="block h-9 w-auto fill-current"/>
                                </Link>
                            </div>

                            <!-- Navigation Links -->
<!--                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">-->
<!--                                <NavLink :href="route('communities.index')" :active="route().current('communities.index')">-->
<!--                                    Communities-->
<!--                                </NavLink>-->
<!--                            </div>-->
                        </div>

                        <div class="sm:flex sm:items-center sm:ms-6">
                            <div class="join join-horizontal">
                                <input v-for="lang in ['en', 'lv', 'ru']" :key="lang" type="radio" name="language" class="btn btn-sm join-item"
                                       :aria-label="lang" :value="lang" v-model="selectedLanguage"
                                />
                            </div>

                            <ThemeToggle class="mx-5"/>

                            <Link :href="route('login')" class="btn btn-soft btn-secondary btn-sm mr-4 uppercase">
                                {{ $t('login') }}
                            </Link>
                            <Link :href="route('register')" class="btn btn-soft btn-secondary btn-sm uppercase">
                                {{ $t('register') }}
                            </Link>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
                    <div class="mt-3 space-y-1">
                        <Link :href="route('login')">
                            {{ $t('login') }}
                        </Link>
                        <Link :href="route('register')">
                            {{ $t('register') }}
                        </Link>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-base-100 shadow-md">
                <slot name="header" />
            </header>

            <!-- Page Content -->
            <main class="max-w-7xl mx-auto mt-6 px-4 sm:px-6 lg:px-8">
                <slot />
            </main>
        </div>
    </div>
</template>
