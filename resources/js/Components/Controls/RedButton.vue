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
        class="flex justify-center rounded-md border border-transparent bg-red-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:bg-red-400"
    >
        <slot />
    </button>
</template>