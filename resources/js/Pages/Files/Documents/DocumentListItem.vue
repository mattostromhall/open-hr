<script setup lang="ts">
import type {DocumentListItem} from '../../../types'
import {DocumentIcon} from '@heroicons/vue/24/outline'
import {FolderIcon} from '@heroicons/vue/24/solid'
import {computed, ref} from 'vue'
import type {Ref} from 'vue'
import {Inertia} from '@inertiajs/inertia'
import {useDateFormat} from '@vueuse/core'
import useFileSizeFormatter from '../../../Composables/useFileSizeFormatter'

const props = defineProps<{
    item: DocumentListItem
}>()

const download: Ref<HTMLAnchorElement | null> = ref(null)

const name = computed(() => {
    return props.item.kind !== 'folder'
        ? `${props.item.name}.${props.item.kind}`
        : props.item.name
})

const modified = computed(() => {
    return props.item.modified && useDateFormat(props.item.modified, 'DD/MM/YYYY HH:ss').value
})

const size = computed(() => {
    return props.item.size && useFileSizeFormatter(props.item.size)
})

function navigate() {
    props.item.kind === 'folder'
        ? Inertia.visit(props.item.path)
        : download.value?.click()
}
</script>

<template>
    <tr
        class="cursor-pointer hover:bg-gray-50"
        @click="navigate"
    >
        <td class="w-5 whitespace-nowrap py-2 pl-3 pr-1 text-sm font-medium text-indigo-500">
            <DocumentIcon
                v-if="item.kind !== 'folder'"
                class="h-5 w-5"
            />
            <FolderIcon
                v-else
                class="h-5 w-5"
            />
        </td>
        <td class="whitespace-nowrap p-2 text-sm font-semibold text-gray-900">
            {{ name }}
        </td>
        <td class="whitespace-nowrap p-2 text-sm text-gray-500">
            {{ modified }}
        </td>
        <td class="whitespace-nowrap p-2 text-sm text-gray-500">
            {{ size }}
        </td>
        <td class="whitespace-nowrap p-2 text-sm text-gray-500">
            {{ item.kind }}
        </td>
        <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
            <a
                v-if="item.kind !== 'folder'"
                ref="download"
                :href="item.path"
                class="text-indigo-600 hover:text-indigo-900"
            >Download</a>
        </td>
    </tr>
</template>