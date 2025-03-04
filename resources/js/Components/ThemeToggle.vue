<script setup>
import { ref, onMounted } from "vue";
import {OiSun, RiMoonClearLine} from "oh-vue-icons/icons";
import {addIcons} from "oh-vue-icons";
addIcons(OiSun, RiMoonClearLine);

const currentTheme = ref("dark");

const themeController = () => {
    const newTheme = currentTheme.value === "light" ? "dark" : "light";
    document.documentElement.setAttribute("data-theme", newTheme);
    localStorage.setItem("userTheme", newTheme);
    currentTheme.value = newTheme;
};

onMounted(() => {
    const savedTheme = localStorage.getItem("userTheme") || "dark";
    document.documentElement.setAttribute("data-theme", savedTheme);
    currentTheme.value = savedTheme;
});
</script>

<template>
    <label class="swap swap-rotate">
        <input @click="themeController" type="checkbox" />

<!--        <v-icon v-if="currentTheme === 'light'" name="oi-sun" class="swap-off h-8 w-8 fill-current text-white"/>-->
<!--        <v-icon v-else name="ri-moon-clear-line" class="swap-on h-8 w-8 fill-current text-black"/>-->

        <v-icon :name="currentTheme === 'light' ? 'ri-moon-clear-line' : 'oi-sun'" class="h-8 w-8 fill-current" :class="{ 'text-white': currentTheme === 'dark', 'text-black': currentTheme === 'light' }"/>
    </label>
</template>
