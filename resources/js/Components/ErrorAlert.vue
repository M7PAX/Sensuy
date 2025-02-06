<script setup>
import {MdReportgmailerrorredSharp} from "oh-vue-icons/icons";
import {addIcons} from "oh-vue-icons";
addIcons(MdReportgmailerrorredSharp);

defineProps({
    message: {
        type: String,
        default: ''
    },
});

</script>

<template>
    <div role="alert" class="alert alert-error text-white dark:text-black" v-show="message">
        <v-icon name="md-reportgmailerrorred-sharp" class="w-8 h-8 text-white dark:text-black"/>
        <span>{{ message }}</span>
    </div>
</template>
