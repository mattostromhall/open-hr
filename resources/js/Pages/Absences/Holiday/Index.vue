<script setup lang="ts">
import {Head} from '@inertiajs/vue3'
import RequestHoliday from './RequestHoliday.vue'
import PageHeading from '@/Components/PageHeading.vue'
import Approved from './Approved.vue'
import Pending from './Pending.vue'
import Rejected from './Rejected.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import type {Breadcrumb, Holiday, TabbedContentItem} from '../../../types'
import TabbedContent from '@/Components/TabbedContent.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import usePermissions from '../../../Hooks/usePermissions'

defineProps<{
    active: TabbedContentItem['identifier'],
    approved: (Pick<Holiday, 'id' | 'start_at' | 'finish_at' | 'half_day' | 'notes'> & {duration: number})[],
    pending: (Pick<Holiday, 'id' | 'start_at' | 'finish_at' | 'half_day' | 'notes'> & {duration: number})[],
    rejected: (Pick<Holiday, 'id' | 'start_at' | 'finish_at' | 'half_day' | 'notes'> & {duration: number})[]
}>()

const {can} = usePermissions()

const breadcrumbs: Breadcrumb[] = [{
    display: 'Holidays'
}]

const tabs: TabbedContentItem[] = [
    {
        identifier: 'request',
        icon: 'ClockIcon',
        display: 'Request Holiday'
    },
    {
        identifier: 'approved',
        icon: 'CheckCircleIcon',
        display: 'Approved'
    },
    {
        identifier: 'pending',
        icon: 'QuestionMarkCircleIcon',
        display: 'Pending'
    },
    {
        identifier: 'rejected',
        icon: 'XCircleIcon',
        display: 'Rejected'
    }
]
</script>

<template>
    <Head>
        <title>Manage Holiday</title>
    </Head>

    <PageHeading>
        Holidays
        <template #link>
            <LightIndigoLink
                v-if="can('view-holiday-calendar')"
                href="/holidays/calendar"
            >
                View calendar
            </LightIndigoLink>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        class="pt-8 px-8"
    />
    <TabbedContent
        v-slot="{setActive, isActive}"
        :tabs="tabs"
        :active="active"
    >
        <RequestHoliday
            v-if="isActive('request')"
            @set-active="setActive"
        />
        <Approved
            v-if="isActive('approved')"
            :approved="approved"
        />
        <Pending
            v-if="isActive('pending')"
            :pending="pending"
        />
        <Rejected
            v-if="isActive('rejected')"
            :rejected="rejected"
        />
    </TabbedContent>
</template>