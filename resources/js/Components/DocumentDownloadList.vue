<script setup lang="ts">
import {PaperClipIcon} from '@heroicons/vue/24/outline'
import type {Document} from '../types'

defineProps<{
    documents?: Document[] | Document
}>()
</script>

<template>
    <ul
        v-if="documents"
        role="list"
        class="divide-y divide-gray-200 rounded-md border border-gray-200"
    >
        <template v-if="Array.isArray(documents)">
            <li
                v-for="document in documents"
                :key="document.path"
                class="flex items-center justify-between py-3 pl-3 pr-4 text-sm"
            >
                <div class="flex w-0 flex-1 items-center">
                    <PaperClipIcon class="h-5 w-5 shrink-0 text-gray-400" />
                    <span class="ml-2 w-0 flex-1 truncate">{{ document.name }}.{{ document.extension }}</span>
                </div>
                <div class="ml-4 shrink-0">
                    <a
                        :href="document.path"
                        class="font-medium text-indigo-600 hover:text-indigo-500"
                    >Download</a>
                </div>
            </li>
        </template>
        <li
            v-else
            class="flex items-center justify-between py-3 pl-3 pr-4 text-sm"
        >
            <div class="flex w-0 flex-1 items-center">
                <PaperClipIcon class="h-5 w-5 shrink-0 text-gray-400" />
                <span class="ml-2 w-0 flex-1 truncate">{{ documents.name }}.{{ documents.extension }}</span>
            </div>
            <div class="ml-4 shrink-0">
                <a
                    :href="documents.path"
                    class="font-medium text-indigo-600 hover:text-indigo-500"
                >Download</a>
            </div>
        </li>
    </ul>
</template>