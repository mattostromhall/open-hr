<script setup lang="ts">
import {Head, Link} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import IndigoLink from '@/Components/Controls/IndigoLink.vue'
import DirectoryList from './DirectoryList.vue'
import FileList from './FileList.vue'
import type {DocumentListItem} from '../../../types'
import {FolderIcon} from '@heroicons/vue/outline'
import usePerson from '../../../Hooks/usePerson'

const props = defineProps<{
    path: string,
    topLevelDirectories: DocumentListItem[],
    directories: DocumentListItem[],
    files: DocumentListItem[]
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
            <DirectoryList :directories="directories" />
            <FileList :files="files" />
        </div>
    </div>
</template>