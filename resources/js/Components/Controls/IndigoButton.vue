<script setup lang="ts">
import type {ComputedRef} from 'vue'
import {computed} from 'vue'

const props = defineProps<{
    type?: string
}>()

const buttonType: ComputedRef<string> = computed(() => props.type ?? 'submit')
</script>

<template>
    <button
        :type="buttonType"
        class="flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:bg-indigo-400"
    >
        <slot />
    </button>
</template>