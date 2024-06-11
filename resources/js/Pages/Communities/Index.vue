<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Pagination from "@/Components/Pagination.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    communities: Object,
});
</script>

<template>
    <Head title="All Communities" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">All Communities</h2>
        </template>

        <div class="max-w-7xl mx-auto px-4 mt-6 sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="overflow-x-auto -mx-4 sm:-mx-6 lg:-mx-8">
                    <div class="max-w-md mx-auto shadow rounded-md p-6 align-middle">
                        <div class="overflow-hidden shadow-md ring-1 ring-black ring-opacity-5 md:rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600">
                            <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                                <thead class="bg-white dark:bg-gray-800">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-black dark:text-white sm:pl-6">
                                            Name
                                        </th>
                                        <th scope="col" class="pr-2">
                                            <div class="flex justify-end">
                                                <PrimaryButton>
                                                    <Link :href="route('communities.create')">
                                                        Add Community
                                                    </Link>
                                                </PrimaryButton>
                                            </div>
                                        </th>
                                            <!--<th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">Slug</th>-->
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600 bg-gray-50 dark:bg-gray-700">
                                    <tr v-for="community in communities.data" :key="community.id">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-black dark:text-white sm:pl-6">
                                            <Link :href="route('frontend.communities.show', community.slug)" class="hover:text-blue-700 dark:hover:text-blue-500">
                                                {{ community.name }}
                                            </Link>
                                        </td>
<!--                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">{{ community.slug}}</td>-->
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <Link :href="route('communities.edit', community.slug)"
                                                  class="text-yellow-500 hover:text-yellow-700 dark:hover:text-yellow-300 mr-5"
                                                  method="get" as="button" type="button">
                                                  Edit
                                            </Link>
                                            <Link :href="route('communities.destroy', community.slug)"
                                                  class="text-red-500 hover:text-red-800 dark:hover:text-red-300"
                                                  method="delete" as="button" type="button">
                                                  Delete
                                            </Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="m-2 p-2">
                                <Pagination :links="communities.links"/>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

    </AuthenticatedLayout>
</template>
