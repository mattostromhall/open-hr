<script setup lang="ts">
import {computed} from 'vue'
import type {ComputedRef} from 'vue'
import {Head, Link} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import IndigoLink from '@/Components/Controls/IndigoLink.vue'
import type {DocumentListItem} from '../../../types'
import {ArrowCircleLeftIcon, FolderIcon} from '@heroicons/vue/outline'
import usePerson from '../../../Hooks/usePerson'
import DocumentList from './DocumentList.vue'

const props = defineProps<{
    path: string,
    topLevelDirectories: DocumentListItem[],
    directories: DocumentListItem[],
    files: DocumentListItem[],
    documentList: DocumentListItem[]
}>()

const person = usePerson()

function isActive(path: string): boolean {
    if (props.path === '/documents/people' && path === '/documents/people') {
        return true
    }

    return props.path.startsWith(path) && path !== '/documents/people'
}
</script>

<template>
    <Head title="Documents" />

    <PageHeading>
        Documents
        <template #link>
            <IndigoLink href="/documents/create">
                Add Documents
            </IndigoLink>
        </template>
    </PageHeading>
    <div class="p-8 lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:col-span-3 lg:p-0">
            <nav class="space-y-1">
                <Link
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive(`/documents/people/${person.id}`),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive(`/documents/people/${person.id}`)
                    }"
                    aria-current="page"
                    :href="`/documents/people/${person.id}`"
                >
                    <FolderIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive(`people/${person.id}`),
                            'text-indigo-500 group-hover:text-indigo-500': isActive(`people/${person.id}`)
                        }"
                    />
                    <span class="truncate">My Documents</span>
                </Link>
                <Link
                    v-for="directory in topLevelDirectories"
                    :key="directory.path"
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive(directory.path),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive(directory.path)
                    }"
                    aria-current="page"
                    :href="directory.path"
                >
                    <FolderIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive(directory.path),
                            'text-indigo-500 group-hover:text-indigo-500': isActive(directory.path)
                        }"
                    />
                    <span class="truncate capitalize">{{ directory.name }}</span>
                </Link>
            </nav>
        </aside>
        <div class="space-y-6 sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0">
            <div
                v-if="directories.length === 0 && files.length === 0"
                class="text-center"
            >
                <svg
                    class="mx-auto h-12 w-12 text-gray-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        vector-effect="non-scaling-stroke"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"
                    />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    No Documents
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Select a different directory to browse or add Documents to this directory.
                </p>
                <div class="mx-auto mt-6 max-w-xs">
                    <IndigoLink href="/documents/create">
                        Add Documents
                    </IndigoLink>
                </div>
            </div>
            <DocumentList :items="documentList" />
        </div>
    </div>
</template>