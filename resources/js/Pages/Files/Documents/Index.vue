<script setup lang="ts">
import {Head, Link} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import IndigoLink from '@/Components/Controls/IndigoLink.vue'
import DirectoryList from './DirectoryList.vue'
import FileList from './FileList.vue'
import type {DocumentListItem} from '../../../types'
import {ArrowCircleLeftIcon, FolderIcon} from '@heroicons/vue/outline'
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
            <!--            <div>-->
            <!--                <button>-->
            <!--                    <ArrowCircleLeftIcon class="h-6 w-6" />-->
            <!--                </button>-->
            <!--            </div>-->
            <!--            <DirectoryList-->
            <!--                v-if="directories"-->
            <!--                :directories="directories"-->
            <!--            />-->
            <!--            <FileList-->
            <!--                v-if="files"-->
            <!--                :files="files"-->
            <!--            />-->
            <div class="flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            scope="col"
                                            class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                        >
                                            Name
                                        </th>
                                        <th
                                            scope="col"
                                            class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Last Modified
                                        </th>
                                        <th
                                            scope="col"
                                            class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Size
                                        </th>
                                        <th
                                            scope="col"
                                            class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                        >
                                            Kind
                                        </th>
                                        <th
                                            scope="col"
                                            class="relative whitespace-nowrap py-3.5 pl-3 pr-4 sm:pr-6"
                                        >
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr
                                        v-for="directory in directories"
                                        :key="directory.name"
                                    >
                                        <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            {{ directory.name }}
                                        </td>
                                        <td class="whitespace-nowrap p-2 text-sm text-gray-500">
                                            {{ directory.modified }}
                                        </td>
                                        <td class="whitespace-nowrap p-2 text-sm text-gray-500">
                                            {{ directory.size }}
                                        </td>
                                        <td class="whitespace-nowrap p-2 text-sm text-gray-500">
                                            {{ directory.kind }}
                                        </td>
                                        <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-6" />
                                    </tr>
                                    <tr
                                        v-for="file in files"
                                        :key="file.name"
                                    >
                                        <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            {{ `${file.name}.${file.kind}` }}
                                        </td>
                                        <td class="whitespace-nowrap p-2 text-sm text-gray-500">
                                            {{ file.modified }}
                                        </td>
                                        <td class="whitespace-nowrap p-2 text-sm text-gray-500">
                                            {{ file.size }}
                                        </td>
                                        <td class="whitespace-nowrap p-2 text-sm text-gray-500">
                                            {{ file.kind }}
                                        </td>
                                        <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <a
                                                :href="file.path"
                                                class="text-indigo-600 hover:text-indigo-900"
                                            >Download</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>