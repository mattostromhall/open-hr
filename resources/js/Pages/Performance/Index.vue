<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import RequestOneToOne from './OneToOnes/RequestOneToOne.vue'
import ScheduleOneToOne from './OneToOnes/ScheduleOneToOne.vue'
import Upcoming from './OneToOnes/Upcoming.vue'
import Current from './Objectives/Current.vue'
import Create from './Objectives/Create.vue'
import type {Objective, OneToOne, Person, SelectOption} from '../../types'
import type {TabbedContentItem} from '../../types'
import TabbedContent from '@/Components/TabbedContent.vue'

defineProps<{
    active: TabbedContentItem['identifier'],
    directReports: (Pick<Person, 'id'|'full_name'>)[],
    recurrenceIntervals: SelectOption[],
    manager: Pick<Person, 'id'|'full_name'>,
    oneToOnes: OneToOne[],
    objectives: Objective[]
}>()

const tabs: TabbedContentItem[] = [
    {
        identifier: 'request',
        icon: 'UsersIcon',
        display: 'Request a One-to-one'
    },
    {
        identifier: 'schedule',
        icon: 'InboxIcon',
        display: 'Schedule One-to-ones'
    },
    {
        identifier: 'upcoming',
        icon: 'ChatBubbleOvalLeftIcon',
        display: 'Upcoming One-to-ones'
    },
    {
        identifier: 'current',
        icon: 'CheckCircleIcon',
        display: 'Current Objectives'
    },
    {
        identifier: 'create',
        icon: 'SparklesIcon',
        display: 'Create an Objective'
    }
]
</script>

<template>
    <Head>
        <title>Performance</title>
    </Head>

    <PageHeading>
        Performance
    </PageHeading>
    <TabbedContent
        v-slot="{setActive, isActive}"
        :tabs="tabs"
        :active="active"
    >
        <RequestOneToOne
            v-if="isActive('request')"
            :manager="manager"
            @set-active="setActive"
        />
        <ScheduleOneToOne
            v-if="isActive('schedule')"
            :direct-reports="directReports"
            :recurrence-intervals="recurrenceIntervals"
            @set-active="setActive"
        />
        <Upcoming
            v-if="isActive('upcoming')"
            :one-to-ones="oneToOnes"
            @set-active="setActive"
        />
        <Current
            v-if="isActive('current')"
            :objectives="objectives"
            @set-active="setActive"
        />
        <Create
            v-if="isActive('create')"
            :direct-reports="directReports"
            @set-active="setActive"
        />
    </TabbedContent>
</template>