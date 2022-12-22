<script setup lang="ts">
import type {Breadcrumb, TabbedContentItem, Training} from '../../../types'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import RequestTraining from './RequestTraining.vue'
import Started from './Started.vue'
import NotStarted from './NotStarted.vue'
import Completed from './Completed.vue'
import AwaitingApproval from './AwaitingApproval.vue'
import TabbedContent from '@/Components/TabbedContent.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'

defineProps<{
    active: TabbedContentItem['identifier'],
    started: Training[],
    notStarted: Training[],
    completed: Training[],
    awaitingApproval: Training[]
}>()

const breadcrumbs: Breadcrumb[] = [
    {
        display: 'Training'
    }
]

const tabs: TabbedContentItem[] = [
    {
        identifier: 'request',
        icon: 'AcademicCapIcon',
        display: 'Request Training'
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
        <title>Training</title>
    </Head>

    <PageHeading>
        Training
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
        <RequestTraining
            v-if="isActive('request')"
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