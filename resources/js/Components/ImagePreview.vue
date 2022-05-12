<script setup lang="ts">
const props = defineProps({
    image: {
        type: String,
        default: ''
    },
    name: {
        type: String,
        default: ''
    }
})
</script>

<template>
    <div
        v-if="props.image"
        class="flex justify-between items-center p-2 pr-4 bg-indigo-50 rounded-md"
    >
        <img
            :src="props.image"
            alt="image preview"
            class="w-auto h-10 rounded"
        >
        <p class="text-xs">
            {{ props.name }}
        </p>
    </div>
</template>