<script setup lang="ts">
import type {Application, TabbedContentItem, Vacancy} from '../../../types'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import TabbedContent from '@/Components/TabbedContent.vue'
import Overview from './Overview.vue'

defineProps<{
    active: TabbedContentItem['identifier'],
    vacancy: Vacancy,
    contact: {
        name: string,
        email: string
    },
    applications: Application[]
}>()

const tabs: TabbedContentItem[] = [
    {
        identifier: 'overview',
        icon: 'InformationCircleIcon',
        display: 'Overview'
    },
    {
        identifier: 'applications',
        icon: 'EnvelopeIcon',
        display: 'Applications'
    },
]
</script>

<template>
    <Head>
        <title>View Vacancy</title>
    </Head>

    <PageHeading>
        Viewing - {{ vacancy.title }}
        <template #link>
            <LightIndigoLink href="/vacancies">
                All Vacancies
            </LightIndigoLink>
        </template>
    </PageHeading>
    <TabbedContent
        v-slot="{isActive}"
        :active="active"
        :tabs="tabs"
    >
        <Overview
            v-if="isActive('overview')"
            :vacancy="vacancy"
            :contact="contact"
        />
    </TabbedContent>
</template>