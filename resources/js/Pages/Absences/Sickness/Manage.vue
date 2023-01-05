<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import type {Breadcrumb, Person, Sickness, TabbedContentItem} from '../../../types'
import TabbedContent from '@/Components/TabbedContent.vue'
import ReportSickness from './ReportSickness.vue'
import Sicknesses from './Sicknesses.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'

defineProps<{
    active: TabbedContentItem['identifier'],
    directReports: (Pick<Person, 'id'|'full_name'>)[],
    sicknesses: (Pick<Sickness, 'id' | 'start_at' | 'finish_at'> & {duration: number})[]
}>()

const breadcrumbs: Breadcrumb[] = [
    {
        display: 'Manage Sick Days'
    }
]

const tabs: TabbedContentItem[] = [
    {
        identifier: 'report',
        icon: 'ClockIcon',
        display: 'Report a Sick day'
    },
    {
        identifier: 'sicknesses',
        icon: 'FaceFrownIcon',
        display: 'Sicknesses this year'
    }
]
</script>

<template>
    <Head>
        <title>Manage Sicknesses</title>
    </Head>

    <PageHeading>
        Manage Sicknesses
        <template #link>
            <LightIndigoLink href="/sicknesses/calendar">
                View calendar
            </LightIndigoLink>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        dashboard="/dashboard/management"
        class="pt-8 px-8"
    />
    <TabbedContent
        v-slot="{setActive, isActive}"
        :tabs="tabs"
        :active="active"
    >
        <ReportSickness
            v-if="isActive('report')"
            :direct-reports="directReports"
            @set-active="setActive"
        />
        <Sicknesses
            v-if="isActive('sicknesses')"
            :sicknesses="sicknesses"
        />
    </TabbedContent>
</template>