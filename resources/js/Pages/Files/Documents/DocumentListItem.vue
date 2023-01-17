<script setup lang="ts">
import type {DocumentListItem} from '../../../types'
import {DocumentIcon, TrashIcon} from '@heroicons/vue/24/outline'
import {FolderIcon} from '@heroicons/vue/24/solid'
import {computed, ref} from 'vue'
import type {Ref} from 'vue'
import RedButton from '@/Components/Controls/RedButton.vue'
import {Inertia} from '@inertiajs/inertia'
import SimpleDropdown from '@/Components/SimpleDropdown.vue'
import {useDateFormat} from '@vueuse/core'
import useFileSizeFormatter from '../../../Composables/useFileSizeFormatter'
import {InertiaForm, useForm} from '@inertiajs/inertia-vue3'
import usePermissions from '../../../Hooks/usePermissions'

const props = defineProps<{
    item: DocumentListItem
}>()

const {can} = usePermissions()

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

function downloadDocument() {
    return download.value?.click()
}

function navigate() {
    props.item.kind === 'folder'
        ? Inertia.visit(props.item.path)
        : downloadDocument()

}

const showDeleteDropdown: Ref<boolean> = ref(false)

interface DirectoryData {
    path: string
}

const form: InertiaForm<DirectoryData> = useForm({
    path: props.item.path
})

function submit() {
    form.post('/directories/delete')
}
</script>

<template>
    <tr class="cursor-pointer hover:bg-gray-50">
        <td
            class="w-5 whitespace-nowrap py-2 pl-3 pr-1 text-sm font-medium text-indigo-500"
            @click="navigate"
        >
            <DocumentIcon
                v-if="item.kind !== 'folder'"
                class="h-5 w-5"
            />
            <FolderIcon
                v-else
                class="h-5 w-5"
            />
        </td>
        <td
            class="whitespace-nowrap p-2 text-sm font-semibold text-gray-900"
            @click="navigate"
        >
            {{ name }}
        </td>
        <td
            class="whitespace-nowrap p-2 text-sm text-gray-500"
            @click="navigate"
        >
            {{ modified }}
        </td>
        <td
            class="whitespace-nowrap p-2 text-sm text-gray-500"
            @click="navigate"
        >
            {{ size }}
        </td>
        <td
            class="whitespace-nowrap p-2 text-sm text-gray-500"
            @click="navigate"
        >
            {{ item.kind }}
        </td>
        <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
            <SimpleDropdown
                v-if="item.kind === 'folder' && can('delete-folder')"
                v-model="showDeleteDropdown"
                position="below-right"
            >
                <template #button="{toggleDropdown}">
                    <button
                        type="button"
                        @click="showDeleteDropdown = true; toggleDropdown"
                    >
                        <TrashIcon class="h-4 w-4 ml-2 text-red-600 hover:text-red-900" /><span class="sr-only">, {{ item.name }}</span>
                    </button>
                </template>
                <template #default="{hideDropdown}">
                    <form @submit.prevent="submit">
                        <RedButton @click="hideDropdown">
                            Confirm
                        </RedButton>
                    </form>
                </template>
            </SimpleDropdown>
            <a
                v-if="item.kind !== 'folder' && can('download-document')"
                ref="download"
                :href="item.path"
                class="text-indigo-600 hover:text-indigo-900"
            >Download</a>
        </td>
    </tr>
</template>