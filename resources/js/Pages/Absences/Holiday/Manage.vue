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

defineProps<{
    active: TabbedContentItem['identifier'],
    approved: Pick<Holiday, 'id' | 'start_at' | 'finish_at' | 'half_day' | 'notes'> & {duration: number},
    pending: Pick<Holiday, 'id' | 'start_at' | 'finish_at' | 'half_day' | 'notes'> & {duration: number},
    rejected: Pick<Holiday, 'id' | 'start_at' | 'finish_at' | 'half_day' | 'notes'> & {duration: number}
}>()

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
            <LightIndigoLink href="/holidays/calendar">
                View calendar
            </LightIndigoLink>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
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