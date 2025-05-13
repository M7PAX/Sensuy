<script setup>
import { Link, router } from "@inertiajs/vue3";
import PostCard from "@/Components/PostCard.vue";
import LayoutPicker from "@/Components/LayoutPicker.vue";
import { HiUserGroup } from "oh-vue-icons/icons";
import { addIcons } from "oh-vue-icons";
import { ref, onMounted, watch, computed } from "vue";
import { useScroll } from "@vueuse/core";
addIcons(HiUserGroup);

const props = defineProps({
    community: Object,
    posts: Object,
    isFollowing: Boolean,
    can_delete: Boolean,
    followers: Number,
});

const titleRef = ref(null);
const selectedTab = ref("all");

const posts = ref(new Map());
let page = ref(0);
const Newposts = ref(props.followers);

const follow = () => {
    router.post(route('communities.follow', props.community.slug), {
        onSuccess: () => {
            props.isFollowing = true;
        },
    });
};

const unfollow = () => {
    router.delete(route('communities.unfollow', props.community.slug), {
        onSuccess: () => {
            props.isFollowing = false;
        },
    });
};

const textInverter = async () => {
    if (!titleRef.value || !props.community?.background) return;

    const img = new Image();
    img.src = `/storage/${props.community.background}`;
    try {
        await img.decode();
    } catch (error) {
        console.error("Image load error:", error);
        return;
    }

    const canvas = document.createElement("canvas");
    canvas.width = 1;
    canvas.height = 1;
    const ctx = canvas.getContext("2d");
    if (!ctx) return;

    ctx.drawImage(img, 0, 0, 1, 1);
    const pixelData = ctx.getImageData(0, 0, 1, 1).data;
    const [r, g, b] = pixelData;
    const luminance = 0.299 * r + 0.587 * g + 0.114 * b;
    const textColor = luminance > 128 ? "#000000" : "#ffffff";
    titleRef.value.style.color = textColor;
};

const filteredPosts = computed(() => {
    const postsArray = Array.from(posts.value.values());

    if (selectedTab.value === 'all') {
        return postsArray;
    }

    return postsArray.filter(post => {
        if (selectedTab.value === 'text') {
            return (
                post.files.length === 0 || !post.files.some(file =>
                    ['image/', 'video/', 'audio/'].some(type => file.mime_type.startsWith(type))
                )
            );
        }

        return post.files.some(file => file.mime_type.startsWith(selectedTab.value));
    });
});

const onLoadMore = async () => {
    const response = await fetch(route("load-community-posts", { slug: props.community.slug }) + `?page=${page.value+1}`);
    const newPosts = await response.json();

    newPosts.forEach((post) => posts.value.set(post.id,post));
    page.value = page.value + 1;
};

const { arrivedState } = useScroll(document, {
    throttle: 100,
    behavior: "smooth",
});

onMounted(() => {
    textInverter();
    onLoadMore();
});

watch(arrivedState, (state) => state.bottom && onLoadMore());

watch(() => props.community?.background, () => {
    textInverter();
});
</script>

<template>
    <LayoutPicker>
        <template #header>
            <div class="relative flex justify-between p-5 rounded-box" :style="{ backgroundImage: community.background ? `url(/storage/${community.background})` : '' }">
                <div v-if="community.background" class="absolute inset-0 bg-cover bg-center opacity-65 rounded-selector" :style="{ backgroundImage: `url(/storage/${community.background})` }"></div>

                <div class="flex items-center justify-center my-auto z-10">
                    <div class="avatar mr-2">
                        <div :class="['mask', 'mask-heart', 'w-10', {'bg-primary': community.picture === null}, {'backdrop-invert': community.picture !== null}]">
                            <v-icon v-if="community.picture === null" name="hi-user-group" class="w-10 h-10 text-base-100 mt-1"/>
                            <img v-else class="w-10 h-10" :src="`/storage/${community.picture}`" alt="Community Icon"/>
                        </div>
                    </div>

                    <h2 ref="titleRef" class="font-semibold text-xl leading-tight">
                        s/{{ community.name }}
                    </h2>

                    <div class="badge badge-soft badge-secondary text-xs ml-3">
                        {{ $t('followers') }}: {{ followers }}
                    </div>
                </div>

                <div v-if="$page.props.auth.auth_check" class="z-10">
                    <button v-if="isFollowing && !can_delete" @click="unfollow" class="btn btn-error btn-soft uppercase mr-5">
                        {{ $t('unfollow') }}
                    </button>

                    <button v-if="!can_delete && !isFollowing" @click="follow" class="btn btn-info uppercase mr-5">
                        {{ $t('follow') }}
                    </button>

                    <Link v-if="isFollowing || can_delete" :href="route('communities.posts.create', community.slug)" class="btn btn-success uppercase">
                        {{ $t('create post') }}
                    </Link>

                    <Link v-if="can_delete" :href="route('communities.destroy', community.slug)" class="btn btn-error uppercase ml-5" method="delete" type="button">
                        {{ $t('delete') }}
                    </Link>
                </div>
            </div>
        </template>

        <div class="m-2 p-2 flex flex-col md:flex-row">
            <div class="w-full md:w-4/12 p-4 order-1 md:order-2">
                <div class="w-full shadow-md rounded-box border border-secondary bg-base-100">
                    <h2 class="font-semibold text-lg p-6 rounded-t-field bg-secondary">
                        {{ $t('about') }} {{ community.name }}
                    </h2>

                    <p class="p-4 rounded-selector whitespace-pre-wrap text-wrap wrap-break-word">
                        {{ community.description }}
                    </p>
                </div>

                <!-- Uncomment the following if you want to include the CommunityList section -->
                <!--
                <CommunityList class="mt-4" :communities="community">
                    <template #title>
                        Latest Communities
                    </template>
                </CommunityList>
                -->
            </div>

            <div class="w-full md:w-8/12 order-2 md:order-1">
                <div class="tabs tabs-border">
                    <input type="radio" name="radio1" class="tab" :aria-label="$t('all')" value="all" v-model="selectedTab" checked="checked"/>
                    <input type="radio" name="radio1" class="tab" :aria-label="$t('images')" value="image" v-model="selectedTab"/>
                    <input type="radio" name="radio1" class="tab" :aria-label="$t('videos')" value="video" v-model="selectedTab"/>
                    <input type="radio" name="radio1" class="tab" :aria-label="$t('audios')" value="audio" v-model="selectedTab"/>
                    <input type="radio" name="radio1" class="tab" :aria-label="$t('texts or links')" value="text" v-model="selectedTab"/>
                </div>

                <PostCard v-if="filteredPosts.length" v-for="post in filteredPosts" :post="post" :community="community.slug" :key="post.id"/>

                <div v-else class="flex items-center justify-center p-5 text-warning text-xl">
                    {{ $t('no posts') }}
                </div>
            </div>
        </div>
    </LayoutPicker>
</template>
