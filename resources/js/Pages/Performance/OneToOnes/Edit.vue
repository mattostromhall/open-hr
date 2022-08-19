<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import type {OneToOne} from '../../../types'

const props = defineProps<{
    oneToOne: OneToOne,
    requester: string,
    personName: string,
    managerName: string,
    personStatus: string,
    managerStatus: string
}>()
</script>

<template>
    <Head title="Editing One-to-one" />

    <PageHeading>
        <span class="font-medium">Editing</span> - One-to-one
        <template #link>
            <LightIndigoLink :href="`/one-to-ones/${oneToOne.id}`">
                View
            </LightIndigoLink>
        </template>
    </PageHeading>
</template>