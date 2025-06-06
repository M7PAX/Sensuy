<script setup>
import {Link} from "@inertiajs/vue3";
import SearchBar from "@/Components/SearchBar.vue";
import {ref} from "vue";

const searchResultsFromChild = ref([]);
const searchErrorFromChild = ref(null);
const modalRef = ref(null);

function handleSearchResults(results) {
    searchResultsFromChild.value = results;
    searchErrorFromChild.value = null;
    modalRef.value.showModal();
}

function handleSearchError(errorMessage) {
    searchErrorFromChild.value = errorMessage;
    searchResultsFromChild.value = [];
    console.error("Search Error in Parent:", errorMessage);
}

</script>

<template>
    <dialog ref="modalRef" class="modal">
        <div class="modal-box flex flex-col items-center">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>

            <SearchBar @search-results="handleSearchResults" @search-error="handleSearchError" />

            <div v-if="searchResultsFromChild.length > 0">
                <div class="mt-4 mx-auto max-md-w">
                    <ul class="menu bg-base-100 rounded-box">
                        <li>
                            <h2 class="menu-title">
                                {{ $t('posts') }}
                            </h2>

                            <ul v-for="result in searchResultsFromChild" :key="result.type + '-' + result.id">
                                <li v-if="result.type === 'p'">
                                    <Link :href="route('posts', [result.community_slug, result.slug])" class="font-bold">
                                        <div>
                                            {{ result.title }}

                                            <p class="text-xs font-normal">
                                                {{ result.description }}
                                            </p>
                                        </div>
                                    </Link>
                                </li>
                            </ul>

                            <h2 class="menu-title">
                                {{ $t('communities') }}
                            </h2>

                            <ul v-for="result in searchResultsFromChild" :key="result.type + '-' + result.id">
                                <li v-if="result.type === 'c'">
                                    <Link :href="route('communities', result.slug)" class="font-bold">
                                        <div>
                                            <div class="avatar mr-2">
                                                <div class="mask mask-heart w-8 bg-primary group-hover:bg-secondary">
                                                    <v-icon v-if="result.community_picture === undefined" name="hi-user-group" class="w-8 h-8 text-base-100 mt-1"/>
                                                    <img v-else :src="`/storage/${result.community_picture}`"/>
                                                </div>
                                            </div>

                                            {{ result.name }}

                                            <p class="text-xs font-normal">
                                                {{ result.description }}
                                            </p>
                                        </div>
                                    </Link>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <div v-else class="text-xl text-warning flex items-center justify-center m-5">
                {{ $t('no results') }}
            </div>
        </div>
    </dialog>
</template>
