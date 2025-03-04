<script setup>
import UpVote from "@/Components/UpVote.vue";
import DownVote from "@/Components/DownVote.vue";

defineProps({
    post: Object
});
</script>

<template>
    <div class="w-12 flex flex-col h-full p-2 text-center">
        <UpVote :slug="post.slug" :class="{'text-success': post.voted[0] && post.voted[0].vote === 1}"/>
        <div class="p-2 my-2 font-bold" :class="{
            'text-success': post.voted[0] && post.voted[0].vote === 1,
            'text-error': post.voted[0] && post.voted[0].vote === -1
        }">
            {{ post.votes }}
        </div>
        <DownVote :slug="post.slug" :class="{'text-error': post.voted[0] && post.voted[0].vote === -1}"/>
    </div>
</template>
