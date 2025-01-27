<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import PostCard from "@/Components/PostCard.vue";
import CommunityList from "@/Components/CommunityList.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

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
    <component :is="$page.props.auth.auth_check ? AuthenticatedLayout : GuestLayout">
        <section class="m-2 p-2 flex flex-col md:flex-row">
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
    </component>
</template>
