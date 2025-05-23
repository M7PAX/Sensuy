<script setup>
import { onMounted, ref, watch} from 'vue';
import Logo from '@/Components/Logo.vue';
import { Link, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import SearchBar from "@/Components/SearchBar.vue";
import { RiUser3Line } from "oh-vue-icons/icons";
import { addIcons } from "oh-vue-icons";
addIcons(RiUser3Line);

const { locale } = useI18n();
const user = usePage().props.auth?.user;
const showingNavigationDropdown = ref(false);
const showMessage = ref(false);
const currentMessage = ref(null);
const searchResultsFromChild = ref([]);
const searchErrorFromChild = ref(null);
const modalRef = ref(null);

const initializeLanguage = () => {
    locale.value = user.language;
    document.documentElement.setAttribute('lang', user.language);
};

const initializeTheme = () => {
    document.documentElement.setAttribute('data-theme', user.theme);
};

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

watch(() => user.language, (newLanguage) => {
    locale.value = newLanguage;
    document.documentElement.setAttribute('lang', newLanguage);
});

watch(() => user.theme, (newTheme) => {
    document.documentElement.setAttribute('data-theme', newTheme);
});

watch(() => usePage().props.flash.message, (newMessage) => {
    if (newMessage) {
        showMessage.value = true;
        currentMessage.value = newMessage;

        setTimeout(() => {
            showMessage.value = false;
        }, 3000);
    }
});

onMounted(() => {
    initializeLanguage();
    initializeTheme();
});
</script>

<template>
    <div>
        <div v-if="$page.props.flash.message && showMessage" class="bg-success fade-out">
            <div class="max-w-7xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between flex-wrap">
                    <div class="w-0 flex-1 flex items-center">
                        <p class="ml-3 font-medium truncate">
                            <span class="md:hidden">
                                {{ $page.props.flash.message }}
                            </span>
                            <span class="hidden md:inline">
                                {{ $page.props.flash.message }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

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

                        <div class="hidden sm:flex sm:items-center w-full justify-end">
                            <div class="mx-auto">
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
                                                        <h2 class="menu-title">Posts</h2>

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

                                                        <h2 class="menu-title">Communities</h2>

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
                                            No Results Found
                                        </div>
                                    </div>
                                </dialog>
                            </div>

                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <div class="dropdown dropdown-bottom dropdown-hover dropdown-end">
                                    <div tabindex="0" role="button" class="btn btn-ghost m-1">
                                        <div class="avatar mr-2">
                                            <div :class="['mask', 'w-8', 'bg-accent', $page.props.auth.user.is_admin ? 'mask-hexagon' : 'mask-hexagon-2']">
                                                <v-icon v-if="$page.props.auth.user.picture=== null" name="ri-user-3-line" class="w-8 h-8 text-base-100 mt-0.5"/>
                                                <img v-else :src="`/storage/${$page.props.auth.user.picture}`"/>
                                            </div>
                                        </div>

                                        {{ $page.props.auth.user.username }}
                                    </div>
                                    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 shadow-sm">
                                        <li>
                                            <Link :href="route('communities.index')" class="uppercase btn btn-soft btn-accent btn-sm">
                                                {{ $t('communities') }}
                                            </Link>
                                        </li>

                                        <li>
                                            <Link :href="route('profile.edit')" class="uppercase btn btn-soft btn-accent btn-sm">
                                                {{ $t('profile n settings') }}
                                            </Link>
                                        </li>

                                        <li>
                                            <a v-if="$page.props.auth.user.is_admin === true" href="/admin/users" class="uppercase btn btn-soft btn-accent btn-sm">
                                                {{ $t('admin panel') }}
                                            </a>
                                        </li>

                                        <li>
                                            <Link :href="route('logout')" method="post" class="uppercase btn btn-soft btn-error btn-sm">
                                                {{ $t('logout') }}
                                            </Link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{ hidden: showingNavigationDropdown,'inline-flex': !showingNavigationDropdown }"
                                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 border-t border-primary">
                        <div class="px-4">
                            <div class="avatar mr-2">
                                <div class="mask mask-hexagon-2 w-8 bg-accent">
                                    <v-icon v-if="$page.props.auth.user.picture=== null" name="ri-user-3-line" class="w-8 h-8 text-base-100 mt-0.5"/>
                                    <img v-else :src="`/storage/${$page.props.auth.user.picture}`" alt="Profile Picture"/>
                                </div>
                            </div>

                            {{ $page.props.auth.user.username }}
                        </div>

                        <div class="my-3 space-y-1 join join-vertical w-full">
                            <Link :href="route('communities.index')" class="max-w-full btn btn-wide btn-soft btn-accent join-item uppercase">
                                {{ $t('communities') }}
                            </Link>

                            <Link :href="route('profile.edit')" class="max-w-full btn btn-wide btn-soft btn-accent join-item uppercase">
                                {{ $t('profile n settings') }}
                            </Link>

                            <a v-if="$page.props.auth.user.is_admin === true" href="/admin/users" class="max-w-full btn btn-wide btn-soft btn-accent join-item uppercase">
                                {{ $t('admin panel') }}
                            </a>

                            <Link :href="route('logout')" class="max-w-full btn btn-wide btn-soft btn-error join-item uppercase" method="post">
                                {{ $t('logout') }}
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
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <slot />
            </main>
        </div>
    </div>
</template>
