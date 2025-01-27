<script setup>
import { useDark, useToggle } from "@vueuse/core";
import {OiSun, RiMoonClearLine} from "oh-vue-icons/icons";
import {addIcons} from "oh-vue-icons";
addIcons(OiSun, RiMoonClearLine);


const isDark = useDark();
const toggleDark = useToggle(isDark);
const test = () => setTimeout(toggleDark,20)
</script>

<template>
    <label class="swap swap-rotate">
        <input @click="test" type="checkbox" class="theme-controller" value="synthwave" />

        <v-icon name="oi-sun" class="swap-off h-8 w-8 fill-current text-white"/>
        <v-icon name="ri-moon-clear-line" class="swap-on h-8 w-8 fill-current text-black"/>
    </label>
</template>
