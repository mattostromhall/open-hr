<script setup lang="ts">
import {onBeforeMount} from 'vue'
import axios from 'axios'
import SearchableSelectInput from './SearchableSelectInput.vue'
import type {SelectOption} from '../../types'
import type {Ref} from 'vue'
import {ref} from 'vue'

const props = defineProps<{
    model: string,
    value: string,
    display: string
}>()

const options: Ref<SelectOption[]> = ref([])

onBeforeMount(async () => {
    const {data} = await axios.get(`/relationship-options/${props.model}`)

    options.value = data.map((option: { [key: string]: string | number }) => {
        return {
            value: option[props.value],
            display: option[props.display]
        }
    })
})
</script>

<template>
    <SearchableSelectInput :options="options" />
</template>