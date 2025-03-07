<script setup>
import { ref } from 'vue';
import Logo from '@/Components/Logo.vue';
import { Link } from '@inertiajs/vue3';
import ThemeToggle from "@/Components/ThemeToggle.vue";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div v-if="$page.props.flash.message" class="bg-success-400">
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

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <ThemeToggle class="mr-5"/>

                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <div class="dropdown dropdown-end">
                                    <div tabindex="0" role="button" class="flex items-center btn btn-ghost">
                                        {{ $page.props.auth.user.username }}
                                    </div>
                                    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
                                        <li>
                                            <Link :href="route('communities.index')">Communities</Link>
                                        </li>
                                        <li>
                                            <Link :href="route('profile.edit')">Profile</Link>
                                        </li>
                                        <li>
                                            <Link :href="route('logout')" method="post" class="text-error">Log Out</Link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">flex-grow mr-2
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
                    <div class="pt-2 pb-3 space-y-1">
                        <Link :href="route('communities.index')" :active="route().current('communities.index')">
                            Communities
                        </Link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t">
                        <div class="px-4">
                            <div class="font-medium text-base">
                                {{ $page.props.auth.user.username }}
                            </div>
                            <div class="font-medium text-sm">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <Link :href="route('profile.edit')">
                                Profile
                            </Link>
                            <Link :href="route('logout')" method="post" as="button">
                                Log Out
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
            <main class="max-w-7xl mx-auto mt-6 px-4 sm:px-6 lg:px-8">
                <slot />
            </main>
        </div>
    </div>
</template>
