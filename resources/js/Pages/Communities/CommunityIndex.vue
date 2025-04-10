<script setup>
import { Head, Link } from '@inertiajs/vue3';
import LayoutPicker from "@/Components/LayoutPicker.vue";

defineProps({
    communities: Object,
});
</script>

<template>
    <Head :title="$t('my communities')" />

    <LayoutPicker>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">
                {{ $t('my communities') }}
            </h2>
        </template>

        <div class="flex flex-col">
            <div class="mx-auto shadow-md rounded-box p-6 align-middle overflow-x-auto bg-base-100 border border-primary">
                <div class="flex justify-end">
                    <Link :href="route('communities.create')" class="btn btn-success uppercase" as="button">
                        {{ $t('add community') }}
                    </Link>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ $t('community name') }}</th>
<!--                            <th>Job</th>-->
<!--                            <th>Slug</th>-->
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="community in communities.data" :key="community.id">
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar mr-2">
                                        <div class="mask mask-heart w-12 bg-primary group-hover:bg-secondary">
                                            <v-icon v-if="community.picture === null" name="hi-user-group" class="w-12 h-12 text-base-100 mt-1"/>
                                            <img v-else :src="`/storage/${community.picture}`" alt="Community Picture"/>
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
                                    {{ $t('edit') }}
                                </Link>

                                <Link :href="route('communities.destroy', community.slug)" class="btn btn-error btn-sm uppercase" method="delete" as="button" type="button">
                                    {{ $t('delete') }}
                                </Link>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </LayoutPicker>
</template>
