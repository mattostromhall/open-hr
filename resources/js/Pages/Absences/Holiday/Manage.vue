<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
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
    display: 'Manage Holidays'
}]

const tabs: TabbedContentItem[] = [
    {
        identifier: 'pending',
        icon: 'QuestionMarkCircleIcon',
        display: 'Pending'
    },
    {
        identifier: 'approved',
        icon: 'CheckCircleIcon',
        display: 'Approved'
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
        dashboard="/dashboard/management"
        class="pt-8 px-8"
    />
    <TabbedContent
        v-slot="{isActive}"
        :tabs="tabs"
        :active="active"
    >
        <Pending
            v-if="isActive('pending')"
            :pending="pending"
            :managing="true"
        />
        <Approved
            v-if="isActive('approved')"
            :approved="approved"
            :managing="true"
        />
        <Rejected
            v-if="isActive('rejected')"
            :rejected="rejected"
            :managing="true"
        />
    </TabbedContent>
</template>