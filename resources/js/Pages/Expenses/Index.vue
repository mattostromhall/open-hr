<script setup lang="ts">
import {Head} from '@inertiajs/vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import type {Breadcrumb, ExpenseWithType, SelectOption, TabbedContentItem} from '../../types'
import Submit from './Submit.vue'
import Approved from './Approved.vue'
import Pending from './Pending.vue'
import Rejected from './Rejected.vue'
import TabbedContent from '@/Components/TabbedContent.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'

defineProps<{
    active: TabbedContentItem['identifier'],
    expenseTypes: SelectOption[],
    approved: ExpenseWithType[],
    pending: ExpenseWithType[],
    rejected: ExpenseWithType[]
}>()

const breadcrumbs: Breadcrumb[] = [
    {
        display: 'Expenses'
    }
]

const tabs: TabbedContentItem[] = [
    {
        identifier: 'submit',
        icon: 'ClockIcon',
        display: 'Submit an Expense'
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
        <title>Manage Expenses</title>
    </Head>

    <PageHeading>
        Expenses
        <template #link>
            <LightIndigoLink href="/dashboard">
                Dashboard
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
        <Submit
            v-if="isActive('submit')"
            :expense-types="expenseTypes"
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