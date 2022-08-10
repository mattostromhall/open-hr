<script setup lang="ts">
import {FolderAddIcon} from '@heroicons/vue/outline'

function showNameInput() {
    console.log('showing name')
}
</script>

<template>
    <tr
        class="cursor-pointer bg-blue-50"
        @click="showNameInput"
    >
        <td class="w-5 whitespace-nowrap py-2 pl-3 pr-1 text-sm font-medium text-blue-500">
            <FolderAddIcon class="h-5 w-5" />
        </td>
        <td class="whitespace-nowrap p-2 text-xs text-blue-500">
            Add folder
        </td>
        <td />
        <td />
        <td />
        <td />
    </tr>
</template>