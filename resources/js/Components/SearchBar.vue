<script setup>
import { ref } from 'vue';
import { IoSearch } from "oh-vue-icons/icons";
import { addIcons } from "oh-vue-icons";
addIcons(IoSearch);

const searchQuery = ref('');
const searchResults = ref([]);
const searchError = ref(null);
const emit = defineEmits(['search-results', 'search-error']);

async function performSearch() {
    if (searchQuery.value.trim() === '') {
        searchResults.value = [];
        searchError.value = null;
        emit('search-results', []);
        return;
    }

    searchError.value = null;
    try {
        const response = await fetch(route("search", { query: encodeURIComponent(searchQuery.value) }));

        searchResults.value = await response.json();
        emit('search-results', searchResults.value);

    } catch (error) {
        console.error("Search failed:", error);
        searchResults.value = [];
        searchError.value = error.message;
        emit('search-error', error.message);
    }
}

</script>

<template>
    <div class="join w-96">
        <div class="w-full">
            <input
                v-model="searchQuery"
                @keyup.enter="performSearch"
                class="input join-item input-secondary w-full"
                placeholder="Search"
            />
        </div>

        <div class="indicator">
            <button @click="performSearch" class="btn join-item btn-secondary">
                <v-icon name="io-search" />
            </button>
        </div>
    </div>
</template>
