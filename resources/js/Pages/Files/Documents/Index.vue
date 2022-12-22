<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import {Head, Link} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import type {Breadcrumb, Documentable, DocumentListItem} from '../../../types'
import {FolderIcon} from '@heroicons/vue/24/outline'
import usePerson from '../../../Hooks/usePerson'
import DocumentList from './DocumentList.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import SimpleModal from '@/Components/SimpleModal.vue'
import UploadDocuments from './UploadDocuments.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'

const props = defineProps<{
    path: string,
    documentable: Documentable
    topLevelDirectories: DocumentListItem[],
    directories: DocumentListItem[],
    files: DocumentListItem[],
    documentList: DocumentListItem[],
    backPath?: string
}>()

const breadcrumbParts = props.path
    .substring(11)
    .split('/')
    .map((part: string) => {
        return {
            link: props.path.substring(0, props.path.indexOf(part)) + part,
            display: part
        }
    })
    .filter((breadcrumb: Breadcrumb) => breadcrumb.display)

const breadcrumbs: Breadcrumb[] = [
    {
        link: '/documents',
        display: 'Documents'
    },
    ...breadcrumbParts
]

const person = usePerson()

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
    <Head>
        <title>Documents</title>
    </Head>

    <PageHeading>
        Documents
        <template #link>
            <IndigoButton @click="showDocumentsModal">
                Add Documents
                <SimpleModal
                    v-model="showAddDocuments"
                >
                    <UploadDocuments
                        :path="props.path"
                        :documentable="documentable"
                        @uploaded="hideDocumentsModal"
                    />
                </SimpleModal>
            </IndigoButton>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        class="pt-8 px-8"
    />
    <div class="p-8 lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:col-span-3 lg:p-0">
            <nav class="space-y-1">
                <Link
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive(`/documents/people/${person.full_name}`),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive(`/documents/people/${person.full_name}`)
                    }"
                    aria-current="page"
                    :href="`/documents/people/${person.full_name}`"
                >
                    <FolderIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive(`people/${person.full_name}`),
                            'text-indigo-500 group-hover:text-indigo-500': isActive(`people/${person.full_name}`)
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
            <DocumentList
                :path="props.path"
                :back-path="props.backPath"
                :items="documentList"
            />
            <UploadDocuments
                :path="props.path"
                :documentable="documentable"
            />
        </div>
    </div>
</template>