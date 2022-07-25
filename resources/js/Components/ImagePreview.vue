<script setup lang="ts">
import type {ComputedRef} from 'vue'
import {computed} from 'vue'

const props = defineProps<{
    image: File | string
    name: string
}>()

const image: ComputedRef<string> =  computed(() => props.image instanceof File
    ? URL.createObjectURL(props.image)
    : props.image
)
</script>

<template>
    <div
        v-if="image"
        class="flex items-center justify-between rounded-md bg-indigo-50 p-2 pr-4"
    >
        <img
            :src="image"
            alt="image preview"
            class="h-10 w-auto rounded"
        >
        <p class="text-xs">
            {{ name }}
        </p>
    </div>
</template>