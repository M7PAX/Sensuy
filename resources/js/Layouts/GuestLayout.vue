<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import ThemeToggle from "@/Components/ThemeToggle.vue";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link href="/">
                                    <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"/>
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
                            <ThemeToggle class="mr-5"/>

                            <Link :href="route('login')" class="btn btn-outline btn-info btn-sm mr-4 hover:text-white dark:hover:text-black">Log in</Link>
                            <Link :href="route('register')" class="btn btn-outline btn-info btn-sm hover:text-white dark:hover:text-black">Register</Link>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
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
                        <ResponsiveNavLink :href="route('login')">
                            Log In
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('register')">
                            Register
                        </ResponsiveNavLink>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white dark:bg-gray-800 shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="max-w-7xl mx-auto mt-6 px-4 sm:px-6 lg:px-8">
                <slot />
            </main>
        </div>
    </div>
</template>
