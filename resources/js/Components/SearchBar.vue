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

        <select class="select join-item w-fit select-secondary">
            <option selected>{{ $t('all') }}</option>
            <option>{{ $t('images') }}</option>
            <option>{{ $t('videos') }}</option>
            <option>{{ $t('audios') }}</option>
            <option>{{ $t('texts') }}</option>
        </select>

        <div class="indicator">
            <button class="btn join-item btn-secondary">
                <v-icon name="io-search"/>
            </button>
        </div>
    </div>
</template>
