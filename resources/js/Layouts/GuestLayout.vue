<script setup>
import {onMounted, ref, watch} from 'vue';
import Logo from '@/Components/Logo.vue';
import { Link } from '@inertiajs/vue3';
import ThemeToggle from "@/Components/ThemeToggle.vue";
import {useI18n} from "vue-i18n";
import SearchBar from "@/Components/SearchBar.vue";
import {i18n, setI18nLanguage} from "@/i18n.js";

const showingNavigationDropdown = ref(false);

const { locale } = useI18n();
const selectedLanguage = ref(locale.value);
const searchResultsFromChild = ref([]);
const searchErrorFromChild = ref(null);
const modalRef = ref(null);

function handleSearchResults(results) {
    searchResultsFromChild.value = results;
    searchErrorFromChild.value = null;
    modalRef.value.showModal();
}

function handleSearchError(errorMessage) {
    searchErrorFromChild.value = errorMessage;
    searchResultsFromChild.value = [];
    console.error("Search Error in Parent:", errorMessage);
}

watch(selectedLanguage, (newLocale) => {
    locale.value = newLocale;
    localStorage.setItem('user-locale', newLocale);
    setI18nLanguage(i18n, newLocale);
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
                                <Link href="/" class="flex items-center text-primary hover:text-secondary">
                                    <Logo class="h-10 w-auto"/>
                                    <div class="text-2xl ml-2">
                                        SENSUY
                                    </div>
                                </Link>
                            </div>

                            <!-- Navigation Links -->
<!--                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">-->
<!--                                <NavLink :href="route('communities.index')" :active="route().current('communities.index')">-->
<!--                                    Communities-->
<!--                                </NavLink>-->
<!--                            </div>-->
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <div class="mr-5">
                                <SearchBar @search-results="handleSearchResults" @search-error="handleSearchError" />

                                <dialog ref="modalRef" class="modal">
                                    <div class="modal-box flex flex-col items-center">
                                        <form method="dialog">
                                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                        </form>

                                        <SearchBar @search-results="handleSearchResults" @search-error="handleSearchError" />

                                        <div v-if="searchResultsFromChild.length > 0">
                                            <div class="mt-4 mx-auto max-md-w">
                                                <ul class="menu bg-base-100 rounded-box">
                                                    <li>
                                                        <h2 class="menu-title">
                                                            {{ $t('posts') }}
                                                        </h2>

                                                        <ul v-for="result in searchResultsFromChild" :key="result.type + '-' + result.id">
                                                            <li v-if="result.type === 'p'">
                                                                <Link :href="route('posts', [result.community_slug, result.slug])" class="font-bold">
                                                                    <div>
                                                                        {{ result.title }}

                                                                        <p class="text-xs font-normal">
                                                                            {{ result.description }}
                                                                        </p>
                                                                    </div>
                                                                </Link>
                                                            </li>
                                                        </ul>

                                                        <h2 class="menu-title">
                                                            {{ $t('communities') }}
                                                        </h2>

                                                        <ul v-for="result in searchResultsFromChild" :key="result.type + '-' + result.id">
                                                            <li v-if="result.type === 'c'">
                                                                <Link :href="route('communities', result.slug)" class="font-bold">
                                                                    <div>
                                                                        <div class="avatar mr-2">
                                                                            <div class="mask mask-heart w-8 bg-primary group-hover:bg-secondary">
                                                                                <v-icon v-if="result.community_picture === undefined" name="hi-user-group" class="w-8 h-8 text-base-100 mt-1"/>
                                                                                <img v-else :src="`/storage/${result.community_picture}`"/>
                                                                            </div>
                                                                        </div>

                                                                        {{ result.name }}

                                                                        <p class="text-xs font-normal">
                                                                            {{ result.description }}
                                                                        </p>
                                                                    </div>
                                                                </Link>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div v-else class="text-xl text-warning flex items-center justify-center m-5">
                                            {{ $t('no results') }}
                                        </div>
                                    </div>
                                </dialog>
                            </div>

                            <div class="join join-horizontal">
                                <input v-for="lang in ['EN', 'LV', 'RU']" type="radio" class="btn btn-sm join-item w-12"
                                       :aria-label="lang" :value="lang" v-model="selectedLanguage"
                                />
                            </div>

                            <ThemeToggle class="mx-5"/>

                            <Link :href="route('login')" :class="['btn', 'btn-sm', 'mr-4', 'uppercase',
                                route().current('login') ? 'btn-secondary' : ['btn-soft', 'btn-secondary'] ]">
                                {{ $t('login') }}
                            </Link>

                            <Link :href="route('register')" :class="['btn', 'btn-sm', 'mr-4', 'uppercase',
                                route().current('register') ? 'btn-secondary' : ['btn-soft', 'btn-secondary'] ]">
                                {{ $t('register') }}
                            </Link>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <div class="join join-horizontal">
                                <input v-for="lang in ['EN', 'LV', 'RU']" :key="lang" type="radio" class="btn btn-sm join-item w-12"
                                       :aria-label="lang" :value="lang" v-model="selectedLanguage"
                                />
                            </div>

                            <ThemeToggle class="mx-5"/>

                            <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-selector">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown,}"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"
                                    />

                                    <path :class="{hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown,}"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
                    <div class="mb-2 mx-2">
                        <SearchBar class="w-full" @search-results="handleSearchResults" @search-error="handleSearchError" />

                        <dialog ref="modalRef" class="modal">
                            <div class="modal-box flex flex-col items-center">
                                <form method="dialog">
                                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                </form>

                                <SearchBar @search-results="handleSearchResults" @search-error="handleSearchError" />

                                <div v-if="searchResultsFromChild.length > 0">
                                    <div class="mt-4 mx-auto max-md-w">
                                        <ul class="menu bg-base-100 rounded-box">
                                            <li>
                                                <h2 class="menu-title">
                                                    {{ $t('posts') }}
                                                </h2>

                                                <ul v-for="result in searchResultsFromChild" :key="result.type + '-' + result.id">
                                                    <li v-if="result.type === 'p'">
                                                        <Link :href="route('posts', [result.community_slug, result.slug])" class="font-bold">
                                                            <div>
                                                                {{ result.title }}

                                                                <p class="text-xs font-normal">
                                                                    {{ result.description }}
                                                                </p>
                                                            </div>
                                                        </Link>
                                                    </li>
                                                </ul>

                                                <h2 class="menu-title">
                                                    {{ $t('communities') }}
                                                </h2>

                                                <ul v-for="result in searchResultsFromChild" :key="result.type + '-' + result.id">
                                                    <li v-if="result.type === 'c'">
                                                        <Link :href="route('communities', result.slug)" class="font-bold">
                                                            <div>
                                                                <div class="avatar mr-2">
                                                                    <div class="mask mask-heart w-8 bg-primary group-hover:bg-secondary">
                                                                        <v-icon v-if="result.community_picture === undefined" name="hi-user-group" class="w-8 h-8 text-base-100 mt-1"/>
                                                                        <img v-else :src="`/storage/${result.community_picture}`"/>
                                                                    </div>
                                                                </div>

                                                                {{ result.name }}

                                                                <p class="text-xs font-normal">
                                                                    {{ result.description }}
                                                                </p>
                                                            </div>
                                                        </Link>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div v-else class="text-xl text-warning flex items-center justify-center m-5">
                                    {{ $t('no results') }}
                                </div>
                            </div>
                        </dialog>
                    </div>

                    <div class="border-t border-primary">
                        <div class="my-3 space-y-1 join join-vertical w-full">
                            <Link :href="route('login')" class="max-w-full btn btn-wide btn-soft btn-secondary join-item uppercase" as="button">
                                {{ $t('login') }}
                            </Link>

                            <Link :href="route('register')" class="max-w-full btn btn-wide btn-soft btn-secondary join-item uppercase" as="button">
                                {{ $t('register') }}
                            </Link>
                        </div>
                    </div>

                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-base-100 shadow-md">
                <slot name="header" />
            </header>

            <!-- Page Content -->
            <main class="max-w-7xl mx-auto mt-2 px-4 sm:px-6 lg:px-8">
                <slot />
            </main>
        </div>
    </div>
</template>
