<script setup lang="ts">
import {DocumentIcon} from '@heroicons/vue/outline'
import type {DocumentListItem} from '../../../types'

const props = defineProps<{
    files: DocumentListItem[]
}>()
</script>

<template>
    <ul class="space-y-1">
        <li
            v-for="file in files"
            :key="file"
        >
            <a
                :href="file.path"
                class="flex items-center space-x-2"
            >
                <DocumentIcon class="h-6 w-6 text-indigo-500" />
                <span class="text-sm font-semibold">{{ file.name }}</span>
            </a>
        </li>
    </ul>
</template>