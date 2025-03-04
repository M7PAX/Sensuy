<script setup>
import { Head, Link } from '@inertiajs/vue3';
import LayoutPicker from "@/Components/LayoutPicker.vue";

defineProps({
    communities: Object,
});
</script>

<template>
    <Head title="All Communities" />

    <LayoutPicker>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">All Communities</h2>
        </template>

        <div class="flex flex-col">
            <div class="mx-auto shadow-sm rounded-xl p-6 align-middle overflow-x-auto bg-base-100 border border-primary">
                <div class="flex justify-end">
                    <button class="btn btn-success">
                        <Link :href="route('communities.create')">
                            Add Community
                        </Link>
                    </button>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Community Name</th>
<!--                            <th>Job</th>-->
<!--                            <th>Slug</th>-->
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="community in communities.data" :key="community.id">
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar">
                                        <div class="mask mask-squircle h-12 w-12">
                                            <img src="https://preview.redd.it/could-this-be-the-more-chaos-poster-v0-v1btt7qv0hde1.jpeg?auto=webp&s=17e70207ea2b6b8de8728d1c197a844423cf66fc" alt="pfp"/>
                                        </div>
                                    </div>
                                    <div class="font-bold">
                                        <Link :href="route('frontend.communities.show', community.slug)">
                                            {{ community.name }}
                                        </Link>
                                    </div>
                                </div>
                            </td>
<!--                            <td>-->
<!--                                Zemlak, Daniel and Leannon-->
<!--                                <br />-->
<!--                                <span class="badge badge-ghost badge-sm">Desktop Support Technician</span>-->
<!--                            </td>-->
<!--                            <td>{{community.slug}}</td>-->
                            <th>
                                <button class="btn btn-warning btn-sm mr-5">
                                    <Link :href="route('communities.edit', community.slug)" method="get" as="button" type="button">
                                        Edit
                                    </Link>
                                </button>
                                <button class="btn btn-error btn-sm">
                                    <Link :href="route('communities.destroy', community.slug)" method="delete" as="button" type="button">
                                        Delete
                                    </Link>
                                </button>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </LayoutPicker>
</template>
