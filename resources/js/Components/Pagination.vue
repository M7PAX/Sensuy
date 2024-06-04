<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: Array
})
</script>

<template>
    <div class="flex">
        <template v-for="(link, key) in links" :key="key">
            <div v-if="link.url === null" v-html="link.label"
                class="mb-1 mr-1 px-4 py-3 text-black dark:text-white text-sm leading-4 border rounded border-black dark:border-white">
            </div>
            <Link v-else :href="link.url" v-html="link.label"
                  class="mb-1 mr-1 px-4 py-3 text-black dark:text-white text-sm leading-4
                  border rounded border-black dark:border-white
                  hover:bg-blue-700 dark:hover:bg-blue-500
                  focus:text-blue-400 focus:border-blue-400 dark:focus:text-blue-800 dark:focus:border-blue-800"
                  :class="{ 'bg-blue-500 dark:bg-blue-700': link.active }">
            </Link>
        </template>
    </div>
</template>


