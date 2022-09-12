<script setup lang="ts">
import {PaperClipIcon} from '@heroicons/vue/24/outline'

const props = defineProps<{
    file: File
    name: string
}>()
</script>

<template>
    <div
        v-if="file"
        class="flex items-center justify-between rounded-md bg-indigo-50 p-2 pr-4"
    >
        <div class="rounded bg-blue-600 p-2 text-blue-50">
            <PaperClipIcon class="h-6 w-6" />
        </div>
        <p class="text-xs">
            {{ name }}
        </p>
    </div>
</template>