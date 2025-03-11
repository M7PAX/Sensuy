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
    <div v-show="message" class="text-error">
        <div class="my-auto">
            <v-icon name="md-reportgmailerrorred-sharp" class="w-5 h-5 text-error mr-1"/>
            {{ message }}
        </div>
    </div>
</template>
