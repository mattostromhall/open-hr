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
        class="flex justify-center rounded-md border border-transparent bg-indigo-100 py-2 px-4 text-sm font-medium text-indigo-700 shadow-sm hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:bg-indigo-50"
    >
        <slot />
    </button>
</template>