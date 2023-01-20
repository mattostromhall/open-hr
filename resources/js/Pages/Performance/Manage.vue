<script setup lang="ts">
import {Head} from '@inertiajs/vue3'
import PageHeading from '@/Components/PageHeading.vue'
import ScheduleOneToOne from './OneToOnes/ScheduleOneToOne.vue'
import Upcoming from './OneToOnes/Upcoming.vue'
import Previous from './OneToOnes/Previous.vue'
import Create from './Objectives/Create.vue'
import type {Breadcrumb, OneToOne, Person, SelectOption} from '../../types'
import type {TabbedContentItem} from '../../types'
import TabbedContent from '@/Components/TabbedContent.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'

defineProps<{
    active: TabbedContentItem['identifier'],
    directReports: (Pick<Person, 'id'|'full_name'>)[],
    recurrenceIntervals: SelectOption[],
    upcomingOneToOnes: OneToOne[],
    previousOneToOnes: OneToOne[]
}>()

const breadcrumbs: Breadcrumb[] = [
    {
        display: 'Manage Performance'
    }
]

const tabs: TabbedContentItem[] = [
    {
        identifier: 'schedule',
        icon: 'InboxIcon',
        display: 'Schedule One-to-ones'
    },
    {
        identifier: 'upcoming',
        icon: 'ChatBubbleOvalLeftIcon',
        display: 'Upcoming Direct Report One-to-ones'
    },
    {
        identifier: 'previous',
        icon: 'ChatBubbleOvalLeftEllipsisIcon',
        display: 'Previous Direct Report One-to-ones'
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
        <title>Manage Performance</title>
    </Head>

    <PageHeading>
        Manage Performance
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
        <ScheduleOneToOne
            v-if="isActive('schedule')"
            :direct-reports="directReports"
            :recurrence-intervals="recurrenceIntervals"
            @set-active="setActive"
        />
        <Upcoming
            v-if="isActive('upcoming')"
            :one-to-ones="upcomingOneToOnes"
            @set-active="setActive"
        />
        <Previous
            v-if="isActive('previous')"
            :one-to-ones="previousOneToOnes"
            @set-active="setActive"
        />
        <Create
            v-if="isActive('create')"
            :direct-reports="directReports"
            @set-active="setActive"
        />
    </TabbedContent>
</template>