<script setup>
import PostCard from "@/Components/PostCard.vue";
import CommunityList from "@/Components/CommunityList.vue";
import LayoutPicker from "@/Components/LayoutPicker.vue";
import { Head } from "@inertiajs/vue3";
import { onMounted, ref, watch } from "vue";
import { useScroll } from "@vueuse/core";

const props = defineProps({
    communities: Object,
    posts: Object,
});

const posts = ref(new Map());
let page = ref(0);

async function onLoadMore() {
    const response = await fetch(route("load-posts", {page: page.value+1}));
    const newPosts = await response.json();

    newPosts.forEach((post) => posts.value.set(post.id,post));
    page.value = page.value + 1;
}

const { arrivedState } = useScroll(document, {
    throttle: 100,
    behavior: 'smooth'
})

onMounted(() => onLoadMore())
watch(arrivedState, (state) => (state.bottom ? onLoadMore() : null))

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
        <section class="pb-5 flex flex-col md:flex-row">
            <div class="md:w-8/12 w-full">
                <PostCard v-for="post in posts.values()" :key="post.id" :post="post" :community="post.community"/>
                <div class="w-full flex my-5">
                    <span class="loading loading-infinity text-info mx-auto w-12"></span>
                </div>
            </div>

            <div class="md:w-4/12 w-full p-4">
                <CommunityList :communities="communities.data">
                    <template #title>
                        {{ $t('top communities') }}
                    </template>
                </CommunityList>
            </div>
        </section>
    </LayoutPicker>
</template>
