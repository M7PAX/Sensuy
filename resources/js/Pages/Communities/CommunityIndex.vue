<script setup>
import { Head, Link } from '@inertiajs/vue3';
import LayoutPicker from "@/Components/LayoutPicker.vue";

defineProps({
    communities: Object,
});
</script>

<template>
    <Head title="My Communities" />

    <LayoutPicker>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">My Communities</h2>
        </template>

        <div class="flex flex-col">
            <div class="mx-auto shadow-md rounded-xl p-6 align-middle overflow-x-auto bg-base-100 border border-primary">
                <div class="flex justify-end">
                    <Link :href="route('communities.create')" class="btn btn-success uppercase" as="button">
                        Add Community
                    </Link>
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
                                    <Link :href="route('communities', community.slug)" class="font-bold">
                                        {{ community.name }}
                                    </Link>
                                </div>
                            </td>
<!--                            <td>-->
<!--                                Zemlak, Daniel and Leannon-->
<!--                                <br />-->
<!--                                <span class="badge badge-ghost badge-sm">Desktop Support Technician</span>-->
<!--                            </td>-->
<!--                            <td>{{community.slug}}</td>-->
                            <th>
                                <Link :href="route('communities.edit', community.slug)" class="btn btn-warning btn-sm mr-5 uppercase" method="get" as="button" type="button">
                                    Edit
                                </Link>
                                <Link :href="route('communities.destroy', community.slug)" class="btn btn-error btn-sm uppercase" method="delete" as="button" type="button">
                                    Delete
                                </Link>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </LayoutPicker>
</template>
