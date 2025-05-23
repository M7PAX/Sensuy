<script setup>
import { Head, Link } from '@inertiajs/vue3';
import LayoutPicker from "@/Components/LayoutPicker.vue";
import { HiUserGroup } from "oh-vue-icons/icons";
import { addIcons } from "oh-vue-icons";
addIcons(HiUserGroup);

const props = defineProps({
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
            <div class="mx-auto shadow-md rounded-box p-5 align-middle overflow-x-auto bg-base-100 border border-primary min-w-xl max-w-6xl">
                <div class="flex justify-end">
                    <Link :href="route('communities.create')" class="btn btn-success uppercase">
                        {{ $t('add community') }}
                    </Link>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ $t('community name') }}</th>
                            <th>{{ $t('description') }}</th>
<!--                            <th>Slug</th>-->
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="community in communities.data" :key="community.id">
                            <td>
                                <Link :href="route('communities', community.slug)" class="flex items-center gap-3 hover:text-secondary group">
                                    <div class="avatar mr-2">
                                        <div class="mask mask-heart w-12 bg-primary group-hover:bg-secondary">
                                            <v-icon v-if="community.picture === null" name="hi-user-group" class="w-12 h-12 text-base-100 mt-1"/>
                                            <img v-else :src="`/storage/${community.picture}`"/>
                                        </div>
                                    </div>
                                    <div class="font-bold">
                                        {{ community.name }}
                                    </div>
                                </Link>
                            </td>
<!--                            <td>-->
<!--                                Zemlak, Daniel and Leannon-->
<!--                                <br />-->
<!--                                <span class="badge badge-ghost badge-sm">Desktop Support Technician</span>-->
<!--                            </td>-->
                            <td>{{ community.description }}</td>
                            <th>
                                <Link :href="route('communities.edit', community.slug)" class="btn btn-warning btn-sm mr-5 uppercase" method="get" type="button">
                                    {{ $t('edit') }}
                                </Link>

                                <div class="indicator">
                                    <div class="indicator-item">
                                        <input type="checkbox" class="checkbox checkbox-error checkbox-sm bg-base-100" @click="(e) => e.target.parentNode?.parentNode?.querySelector('div>button.bt')?.classList.toggle('btn-disabled')" />
                                    </div>

                                    <Link :href="route('communities.destroy', community.slug)" class="btn btn-error btn-sm uppercase bt btn-disabled" method="delete" type="button">
                                        {{ $t('delete') }}
                                    </Link>
                                </div>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </LayoutPicker>
</template>
