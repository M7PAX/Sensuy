<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: Array
})
</script>

<template>
    <div v-for="(link, key) in links" :key="key">
        <div class="join">
            <button class="join-item btn" v-if="link.url === null">«</button>
            <button class="join-item btn"></button>
            <button class="join-item btn" :href="link.url">»</button>
        </div>
    </div>
</template>


