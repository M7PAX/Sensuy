<script setup>
import { ref } from 'vue';
import axios from 'axios';
import {OiInfo} from "oh-vue-icons/icons";
import {addIcons} from "oh-vue-icons";
addIcons(OiInfo);

const props = defineProps({
    title: {
        type: String,
        default: ''
    },
    description: {
        type: String,
        default: ''
    }
});

const emit = defineEmits(['update:title', 'update:description', 'error']);
const loading = ref(false);

const parseAiResponse = (reply) => {
    let newTitle = '';
    let newDescription = '';

    const descriptionMatch = reply.match(/Description:(.*)/is);

    if (descriptionMatch && descriptionMatch[1]) {
        newDescription = descriptionMatch[1].trim();
    } else {
        newDescription = reply.trim();
    }

    const titleMatch = reply.match(/Title:(.*)/i);

    if (titleMatch && titleMatch[1]) {
        newTitle = titleMatch[1].split(/Description:/i)[0].trim();
    }

    return { title: newTitle, description: newDescription };
};


const generateAIDescription = async () => {
    if (!props.title && !props.description) {
        emit('error', 'Please provide a title or initial description.');
        return;
    }

    loading.value = true;
    emit('error', '');

    try {
        const prompt = `You are given the following props:
            Title: ${props.title},
            Description: "${props.description}

            Improve the writing quality of both title and description, keeping their original meaning.
            The text may be in English, Latvian, or Russian.
            If it's in any other language, treat it as English.
            Do not include or mention the detected language in your response.
            Only need to capitalize the first word of the title, if its not all capitalized already.

            Response Format:
            If both title and description are provided, respond only with:
            Title: [Improved Title]
            Description: [Improved Description]

            If title is missing or empty, respond only with:
            Description: [Improved Description]

            Do not include anything else in the output—no extra comments, formatting, metadata or "" to the text.`;

        const response = await axios.post('/ai', {
            message: prompt
        });

        if (response.data.reply) {
            const updatedContent = parseAiResponse(response.data.reply);

            if (updatedContent.title) {
                emit('update:title', updatedContent.title);
            }
            if (updatedContent.description) {
                emit('update:description', updatedContent.description);
            }
        }
    } catch (error) {
        console.error('Error fetching AI description:', error);
        emit('error', 'Sorry, I am having trouble connecting. Please try again later.');
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <div class="flex items-center justify-center">
        <button @click.prevent="generateAIDescription" type="button" class="btn btn-outline btn-accent" :disabled="loading">
            <span v-if="loading" class="loading loading-spinner"></span>
            {{ loading ? $t('generating') : $t('generate') }}
        </button>
        <div class="tooltip ml-2" :data-tip="$t('ai') ">
            <v-icon name="oi-info" class="text-accent h-5 w-5"/>
        </div>
    </div>
</template>
