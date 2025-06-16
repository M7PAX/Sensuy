<script setup>
import {Link} from "@inertiajs/vue3";
import SearchBar from "@/Components/SearchBar.vue"; // 1. Import SearchBar
import {ref} from "vue";

const props = defineProps({
    results: {
        type: Array,
        required: true,
    }
});

// 2. Define the events this component can emit to its parent
const emit = defineEmits(['search-results', 'search-error']);

const modalRef = ref(null);

function show() {
    if (modalRef.value) {
        modalRef.value.showModal();
    }
}

defineExpose({
    show
});

</script>

<template>
    <dialog ref="modalRef" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>

            <SearchBar class="w-full px-5" @search-results="results => emit('search-results', results)" @search-error="error => emit('search-error', error)"/>

            <div v-if="results.length > 0">
                <ul class="menu bg-base-100 rounded-box">
                    <li>
                        <template v-if="results.some(r => r.type === 'p')">
                            <h2 class="menu-title">{{ $t('posts') }}</h2>
                            <ul>
                                <li v-for="result in results.filter(r => r.type === 'p')" :key="result.id">
                                    <Link :href="route('posts', [result.community_slug, result.slug])" class="font-bold">
                                        {{ result.title }}
                                        <p class="text-xs font-normal">{{ result.description }}</p>
                                    </Link>
                                </li>
                            </ul>
                        </template>

                        <template v-if="results.some(r => r.type === 'c')">
                            <h2 class="menu-title">{{ $t('communities') }}</h2>
                            <ul>
                                <li v-for="result in results.filter(r => r.type === 'c')" :key="result.id">
                                    <Link :href="route('communities', result.slug)" class="font-bold flex items-center">
                                        <div class="avatar mr-2">
                                            <div class="mask mask-heart w-8 bg-primary">
                                                <v-icon v-if="!result.community_picture" name="hi-user-group" class="w-8 h-8 text-base-100 p-1"/>
                                                <img v-else :src="`/storage/${result.community_picture}`"/>
                                            </div>
                                        </div>
                                        <div>
                                            {{ result.name }}
                                            <p class="text-xs font-normal">{{ result.description }}</p>
                                        </div>
                                    </Link>
                                </li>
                            </ul>
                        </template>
                    </li>
                </ul>
            </div>

            <div v-else class="text-xl text-center text-warning p-5">
                {{ $t('no results') }}
            </div>
        </div>
    </dialog>
</template>

