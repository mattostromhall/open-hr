<script setup lang="ts">
import type {ComputedRef} from 'vue'
import {computed} from 'vue'

const props = defineProps<{
    type?: string
}>()

const buttonType: ComputedRef<string> = computed(() => props.type ?? 'button')
</script>

<template>
    <button
        :type="buttonType"
        class="flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
    >
        <slot />
    </button>
</template>