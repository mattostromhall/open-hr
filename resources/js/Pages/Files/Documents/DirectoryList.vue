<script setup lang="ts">
import {Link} from '@inertiajs/inertia-vue3'
import {FolderIcon} from '@heroicons/vue/outline'
import type {DocumentListItem} from '../../../types'

const props = defineProps<{
    directories: DocumentListItem[]
}>()
</script>

<template>
    <ul class="space-y-1">
        <li
            v-for="directory in directories"
            :key="directory"
        >
            <Link
                :href="directory.path"
                class="flex items-center space-x-2"
            >
                <FolderIcon class="h-6 w-6 text-indigo-500" />
                <span class="text-sm font-semibold">{{ directory.name }}</span>
            </Link>
        </li>
    </ul>
</template>