<script setup lang="ts">
defineProps({
    type: {
        type: String,
        default: 'submit'
    }
})
</script>

<template>
    <button
        :type="type"
        class="flex justify-center py-2 px-4 w-full text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md border border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-sm"
    >
        <slot />
    </button>
</template>