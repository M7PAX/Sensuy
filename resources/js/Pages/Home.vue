<script setup>
import PostCard from "@/Components/PostCard.vue";
import CommunityList from "@/Components/CommunityList.vue";
import LayoutPicker from "@/Components/LayoutPicker.vue";

defineProps({
    communities: Object,
    posts: Object,
});
</script>

<template>
<!--    <guest-layout>-->
<!--        <section class="m-2 p-2 flex flex-col md:flex-row">-->
<!--            <div class="md:w-8/12 w-full">-->
<!--                <PostCard v-for="post in posts.data" :post="post" :community="post.community_slug" :key="post.id"/>-->
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
        <section class="p-5 flex flex-col md:flex-row">
            <div class="md:w-8/12 w-full">
                <PostCard v-for="post in posts.data" :post="post" :community="post.community_slug" :key="post.id"/>
            </div>
            <div class="md:w-4/12 w-full p-4">
                <CommunityList :communities="communities.data">
                    <template #title>
                        Top Communities
                    </template>
                </CommunityList>
            </div>
        </section>
    </LayoutPicker>
</template>
