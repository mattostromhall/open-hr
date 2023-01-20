<script setup lang="ts">
import type {Breadcrumb, Person, TabbedContentItem, Training} from '../../../types'
import {Head} from '@inertiajs/vue3'
import PageHeading from '@/Components/PageHeading.vue'
import AssignTraining from './AssignTraining.vue'
import Started from './Started.vue'
import NotStarted from './NotStarted.vue'
import Completed from './Completed.vue'
import AwaitingApproval from './AwaitingApproval.vue'
import TabbedContent from '@/Components/TabbedContent.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'

defineProps<{
    active: TabbedContentItem['identifier'],
    directReports: (Pick<Person, 'id'|'full_name'>)[],
    started: Training[],
    notStarted: Training[],
    completed: Training[],
    awaitingApproval: Training[]
}>()

const breadcrumbs: Breadcrumb[] = [
    {
        display: 'Manage Training'
    }
]

const tabs: TabbedContentItem[] = [
    {
        identifier: 'assign',
        icon: 'AcademicCapIcon',
        display: 'Assign Training'
    },
    {
        identifier: 'not-started',
        icon: 'BookmarkSlashIcon',
        display: 'Not Started'
    },
    {
        identifier: 'started',
        icon: 'BookmarkIcon',
        display: 'Started'
    },
    {
        identifier: 'completed',
        icon: 'TrophyIcon',
        display: 'Completed'
    },
    {
        identifier: 'awaiting',
        icon: 'ClockIcon',
        display: 'Awaiting Approval'
    }
]
</script>

<template>
    <Head>
        <title>Manage Training</title>
    </Head>

    <PageHeading>
        Manage Training
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
        <AssignTraining
            v-if="isActive('assign')"
            :direct-reports="directReports"
            @set-active="setActive"
        />
        <NotStarted
            v-if="isActive('not-started')"
            :not-started="notStarted"
            @set-active="setActive"
        />
        <Started
            v-if="isActive('started')"
            :started="started"
            @set-active="setActive"
        />
        <Completed
            v-if="isActive('completed')"
            :completed="completed"
            @set-active="setActive"
        />
        <AwaitingApproval
            v-if="isActive('awaiting')"
            :awaiting-approval="awaitingApproval"
            @set-active="setActive"
        />
    </TabbedContent>
</template>