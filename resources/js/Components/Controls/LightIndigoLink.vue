<script setup lang="ts">
import {Link} from '@inertiajs/inertia-vue3'

defineProps<{
    href: string
}>()
</script>

<template>
    <Link
        :href="href"
        class="flex justify-center py-2 px-4 text-sm font-medium text-indigo-600 bg-white hover:bg-gray-50 rounded-md border border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 shadow-sm"
    >
        <slot />
    </Link>
</template>