<script setup>
import PostCard from "@/Components/PostCard.vue";
import CommunityList from "@/Components/CommunityList.vue";
import LayoutPicker from "@/Components/LayoutPicker.vue";
import {Head} from "@inertiajs/vue3";
import {computed, onMounted, ref, watch} from "vue";
import { useScroll } from "@vueuse/core";
import { BiCaretDown } from "oh-vue-icons/icons";
import { addIcons } from "oh-vue-icons";
import {useI18n} from "vue-i18n";
addIcons(BiCaretDown);

const props = defineProps({
    communities: Object,
    posts: Object,
});

const posts = ref(new Map());
let page = ref(0);
const { t } = useI18n();

async function loadPosts() {
    const response = await fetch(route("load-posts", { page: page.value + 1, sort: selected.value }));
    const newPosts = await response.json();

    newPosts.forEach((post) => posts.value.set(post.id, post));
    page.value = page.value + 1;
}

const selected = ref('New');
const options = computed( () =>[
    { value: 'n', label: t('new') },
    { value: 'o', label: t('old') },
    { value: 'mu', label: t('most ups') },
    { value: 'md', label: t('most downs') },
]);

const selectedLabel = computed(() => {
    const opt = options.value.find(o => o.value === selected.value);
    return opt ? opt.label : t('new');
});

function selectOption(option) {
    selected.value = option.value;
    document.activeElement?.blur();
}

const { arrivedState } = useScroll(document, {
    throttle: 100,
    behavior: 'smooth',
});

onMounted(() => loadPosts());

watch(arrivedState, (state) => state.bottom && loadPosts());
watch(selected, () => {
    posts.value.clear();
    page.value = 0;
    loadPosts();
});

// echo.channel('votes')
//     .listen('.up', (post) => {posts.value.set(post.id, post)})
//     .listen('.down', (post) => {posts.value.set(post.id, post)})
//     .listen('.remove', (post) => {posts.value.set(post.id, post)})
// useEchoPublic("votes", ['.up', '.down', '.remove'],(post) => { console.log(post); posts.value.set(post.id, post)})

</script>

<template>
    <Head :title="$t('home')" />

<!--    <guest-layout>-->
<!--        <section class="m-2 p-2 flex flex-col md:flex-row">-->
<!--            <div class="md:w-8/12 w-full">-->
<!--                <PostCard v-for="post in posts.data" :post="post" :community="post.community" :key="post.id"/>-->
<!--            </div>-->
<!--            <div class="md:w-4/12 w-full p-4">-->
<!--                <CommunityList :communities="communities.data">-->
<!--                    <template #title>-->
<!--                        Top Communities-->
<!--                    </template>-->
<!--                </CommunityList>-->
<!--            </div>-->
<!--        </section>-->
<!--    </guest-layout>-->

    <LayoutPicker>
        <section class="pb-5 flex flex-col xl:flex-row">
            <div class="xl:w-8/12 w-full">
                <div class="dropdown dropdown-start" ref="dropdownRef">
                    <div tabindex="0" class="btn btn-secondary mt-4 justify-between w-40">
                        {{ selectedLabel }}
                        <v-icon name="bi-caret-down"/>
                    </div>

                    <ul tabindex="0" class="dropdown-content menu bg-secondary rounded-box z-10 w-40 p-2 shadow-sm">
                        <li v-for="option in options" :key="option.value">
                            <button @click="selectOption(option)" class="btn btn-secondary w-full">
                                {{ option.label }}
                            </button>
                        </li>
                    </ul>
                </div>

                <PostCard v-for="post in posts.values()" :key="post.id" :post="post"/>

<!--                <div class="w-full flex my-5">-->
<!--                    <span class="loading loading-infinity text-info mx-auto w-12"></span>-->
<!--                </div>-->
            </div>

            <div class="xl:w-4/12 w-full p-4">
                <CommunityList :communities="communities.data">
                    <template #title>
                        {{ $t('communities') }}
                    </template>
                </CommunityList>
            </div>
        </section>
    </LayoutPicker>
</template>
