<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import IndigoLink from '@/Components/Controls/IndigoLink.vue'
import DirectoryList from './DirectoryList.vue'
import FileList from './FileList.vue'
import type {DocumentListItem} from '../../../types'

const props = defineProps<{
    directories: DocumentListItem[],
    files: DocumentListItem[]
}>()
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
    <DirectoryList :directories="directories" />
    <FileList :files="files" />
</template>