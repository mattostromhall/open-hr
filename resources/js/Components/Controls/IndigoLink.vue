<script setup lang="ts">
import {Link} from '@inertiajs/vue3'

defineProps<{
    href: string
}>()
</script>

<template>
    <Link
        :href="href"
        class="flex justify-center py-2 px-4 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 disabled:bg-indigo-400 rounded-md border border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-sm"
    >
        <slot />
    </Link>
</template>