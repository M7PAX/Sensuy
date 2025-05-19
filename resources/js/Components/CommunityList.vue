<script setup>
import { Link } from "@inertiajs/vue3";
import { HiUserGroup, BiCaretDown } from "oh-vue-icons/icons";
import { addIcons } from "oh-vue-icons";
import {computed, onMounted, ref} from "vue";
addIcons(HiUserGroup, BiCaretDown);

defineProps({
    communities: Object
})

const communities = ref(new Map());
const selected = ref('Most Followers');
const options = ref([
    { value: 'New', label: 'New' },
    { value: 'Old', label: 'Old' },
    { value: 'Most Posts', label: 'Most Posts' },
    { value: 'Least Posts', label: 'Least Posts' },
    { value: 'Most Followers', label: 'Most Followers' },
    { value: 'Least Followers', label: 'Least Followers' },
]);

const selectedLabel = computed(() => {
    const opt = options.value.find(o => o.value === selected.value);
    return opt ? opt.label : 'Most Followers';
});

function selectOption(option) {
    selected.value = option.value;
    document.activeElement?.blur();
    communities.value.clear();
    fetchCommunities(option.value);
}

async function fetchCommunities(sortOption) {
    const response = await fetch(route("sort-communities",{ sort: sortOption}));
    const data = await response.json();

    data.forEach((community) => communities.value.set(community.id, community));
}

onMounted(() => fetchCommunities('Most Followers'));

</script>

<template>
    <div class="w-full shadow-md rounded-box border border-secondary bg-base-100">
        <div class="p-6 rounded-field bg-secondary flex items-center">
            <div class="dropdown dropdown-start" ref="dropdownRef">
                <div tabindex="0" class="btn btn-primary w-40 justify-between">
                    {{ selectedLabel }}
                    <v-icon name="bi-caret-down"/>
                </div>

                <ul tabindex="0" class="dropdown-content menu bg-primary rounded-box z-10 w-40 p-2 shadow-sm">
                    <li v-for="option in options" :key="option.value">
                        <button @click="selectOption(option)" class="w-full text-left">
                            {{ option.label }}
                        </button>
                    </li>
                </ul>
            </div>

            <h2 class="font-semibold text-lg ml-2">
                <slot name="title"></slot>
            </h2>
        </div>

        <ul role="list" class="divide-y">
            <li v-for="community in communities.values()" :key="community.id" class="py-3 px-5 sm:py-4">
                <div class="flex items-center">
                    <Link :href="route('communities', community.slug)" class="font-semibold truncate text-sm w-3/5 hover:text-secondary group">
                        <div class="avatar mr-2">
                            <div class="mask mask-heart w-8 bg-primary group-hover:bg-secondary">
                                <v-icon v-if="community.picture === null" name="hi-user-group" class="w-8 h-8 text-base-100 mt-1"/>
                                <img v-else :src="`/storage/${community.picture}`"/>
                            </div>
                        </div>
                        {{ community.name }}
                    </Link>

                    <div v-if="'Most Posts' === selectedLabel || 'Least Posts' === selectedLabel">
                        {{ $t('posts') }} - {{ community.posts_count }}
                    </div>

                    <div v-if="'Most Followers' === selectedLabel || 'Least Followers' === selectedLabel">
                        {{ $t('followers') }} - {{ community.followers_count }}
                    </div>

                    <div v-else>
                        {{ community.created_at }}
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>
