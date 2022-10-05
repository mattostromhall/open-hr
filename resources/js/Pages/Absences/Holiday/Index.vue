<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import RequestHoliday from './RequestHoliday.vue'
import PageHeading from '@/Components/PageHeading.vue'
import Approved from './Approved.vue'
import Pending from './Pending.vue'
import Rejected from './Rejected.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import type {SubMenuItem} from '../../../types'
import TabbedContent from '@/Components/TabbedContent.vue'

defineProps({
    active: {
        type: String,
        required: true
    },
    approved: {
        type: Array,
        default: () => []
    },
    pending: {
        type: Array,
        default: () => []
    },
    rejected: {
        type: Array,
        default: () => []
    }
})

const subMenu: SubMenuItem[] = [
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
            <LightIndigoLink href="/holidays/calendar">
                View calendar
            </LightIndigoLink>
        </template>
    </PageHeading>
    <TabbedContent
        v-slot="{setActive, isActive}"
        :sub-menu-items="subMenu"
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