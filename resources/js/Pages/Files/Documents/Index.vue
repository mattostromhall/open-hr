<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import IndigoLink from '@/Components/Controls/IndigoLink.vue'
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
</template>