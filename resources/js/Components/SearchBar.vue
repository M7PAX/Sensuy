<script setup>
import { useFuse } from '@vueuse/integrations/useFuse'
import { shallowRef } from 'vue'
import { IoSearch } from "oh-vue-icons/icons";
import { addIcons } from "oh-vue-icons";
addIcons(IoSearch);

const data = [
    'John Smith',
    'John Doe',
    'Jane Doe',
    'Phillip Green',
    'Peter Brown',
]

const input = shallowRef('Jhon D')

const { results } = useFuse(input, data)

</script>

<template>
    <div class="join">
        <div>
            <div>
                <input class="input join-item input-secondary" placeholder="Search" />
            </div>
        </div>

        <div class="indicator">
            <button class="btn join-item btn-secondary">
                <v-icon name="io-search"/>
            </button>
        </div>
    </div>
</template>
