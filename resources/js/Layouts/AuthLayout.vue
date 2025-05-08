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

const initializeLanguage = () => {
    locale.value = user.language;
    document.documentElement.setAttribute('lang', user.language);
};

const initializeTheme = () => {
    document.documentElement.setAttribute('data-theme', user.theme);
};

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

                        <div class="hidden sm:flex sm:items-center sm:ms-6 w-full justify-end">
<!--                            <SearchBar class="mx-auto"/>-->

                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <div class="dropdown dropdown-bottom dropdown-hover">
                                    <div tabindex="0" role="button" class="btn btn-ghost m-1">
                                        <div class="avatar mr-2">
                                            <div :class="['mask', 'w-8', 'bg-accent', $page.props.auth.user.is_admin ? 'mask-hexagon' : 'mask-hexagon-2']">
                                                <v-icon v-if="$page.props.auth.user.picture=== null" name="ri-user-3-line" class="w-8 h-8 text-base-100 mt-0.5"/>
                                                <img v-else :src="`/storage/${$page.props.auth.user.picture}`" alt="Profile Picture"/>
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
            <main class="max-w-7xl mx-auto mt-2 px-4 sm:px-6 lg:px-8">
                <slot />
            </main>
        </div>
    </div>
</template>
