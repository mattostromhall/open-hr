<script setup lang="ts">
import {computed, ref} from 'vue'
import type {ComputedRef, Ref} from 'vue'
import {Head, Link} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import type {DocumentListItem} from '../../../types'
import {ArrowCircleLeftIcon, FolderIcon} from '@heroicons/vue/outline'
import usePerson from '../../../Hooks/usePerson'
import DocumentList from './DocumentList.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import SimpleModal from '@/Components/SimpleModal.vue'
import UploadDocuments from './UploadDocuments.vue'

const props = defineProps<{
    path: string,
    topLevelDirectories: DocumentListItem[],
    directories: DocumentListItem[],
    files: DocumentListItem[],
    documentList: DocumentListItem[]
}>()

const person = usePerson()

const uploadPath: ComputedRef<string> = computed(() => props.path.substring(10))

const showAddDocuments: Ref<boolean> = ref(false)

function isActive(path: string): boolean {
    if (props.path === '/documents/people' && path === '/documents/people') {
        return true
    }

    return props.path.startsWith(path) && path !== '/documents/people'
}

function showDocumentsModal() {
    showAddDocuments.value = true
}

function hideDocumentsModal() {
    showAddDocuments.value = false
}
</script>

<template>
    <Head title="Documents" />

    <PageHeading>
        Documents
        <template #link>
            <IndigoButton @click="showDocumentsModal">
                Add Documents
                <SimpleModal
                    v-model="showAddDocuments"
                >
                    <UploadDocuments
                        :path="uploadPath"
                        @uploaded="hideDocumentsModal"
                    />
                </SimpleModal>
            </IndigoButton>
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
                <h3 class="mt-2 mb-6 text-sm font-medium text-gray-900">
                    No Documents
                </h3>
                <UploadDocuments :path="uploadPath" />
            </div>
            <DocumentList
                v-if="documentList.length"
                :items="documentList"
            />
        </div>
    </div>
</template>