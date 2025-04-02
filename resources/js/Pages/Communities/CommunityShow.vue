<script setup>
import { Link } from "@inertiajs/vue3";
import PostCard from "@/Components/PostCard.vue";
import LayoutPicker from "@/Components/LayoutPicker.vue";
import { HiUserGroup } from "oh-vue-icons/icons";
import { addIcons } from "oh-vue-icons";
import { ref, onMounted, watch } from "vue";
addIcons(HiUserGroup);

const props = defineProps({
    community: Object,
    posts: Object,
});

const form = ref({
    processing: false,
});

const titleRef = ref(null);

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

onMounted(() => {
    textInverter();
});

watch(
    () => props.community?.background,
    () => {
        textInverter();
    }
);
</script>

<template>
    <LayoutPicker>
        <template #header>
            <div class="relative flex justify-between p-5 rounded-xl" :style="{ backgroundImage: community.background ? `url(/storage/${community.background})` : '' }">
                <div v-if="community.background" class="absolute inset-0 bg-cover bg-center opacity-65 rounded-xl" :style="{ backgroundImage: `url(/storage/${community.background})` }"></div>

                <div class="flex items-center justify-center my-auto z-10">
                    <div class="avatar mr-2">
                        <div :class="['mask', 'mask-heart', 'w-10', {'bg-primary': community.picture === null}, {'backdrop-invert': community.picture !== null}]">
                            <v-icon v-if="community.picture === null" name="hi-user-group" class="w-10 h-10 text-base-100 mt-1"/>
                            <img v-else class="w-10 h-10 mt-1" :src="`/storage/${community.picture}`" alt="Community Icon"/>
                        </div>
                    </div>
                    <h2 ref="titleRef" class="font-semibold text-xl leading-tight">
                        s/{{ community.name }}
                    </h2>
                </div>

                <div v-if="$page.props.auth.auth_check" class="z-10">
                    <Link :href="route('communities.posts.create', community.slug)" class="btn btn-success uppercase">
                        Create Post
                    </Link>
                </div>
            </div>
        </template>

        <div class="m-2 p-2 flex flex-col md:flex-row">
            <div class="w-full md:w-4/12 p-4 order-1 md:order-2">
                <div class="w-full shadow-md rounded-xl border border-secondary bg-base-100">
                    <h2 class="font-semibold text-lg p-6 rounded-t-xl bg-secondary">
                        About {{ community.name }}
                    </h2>
                    <p class="p-4 rounded-b-xl">
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
                <PostCard v-for="post in posts.data" :post="post" :community="community.slug" :key="post.id"/>
            </div>
        </div>
    </LayoutPicker>
</template>
