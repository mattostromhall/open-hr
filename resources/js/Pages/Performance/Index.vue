<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import RequestOneToOne from './OneToOnes/RequestOneToOne.vue'
import Upcoming from './OneToOnes/Upcoming.vue'
import Previous from './OneToOnes/Previous.vue'
import Current from './Objectives/Current.vue'
import type {Breadcrumb, Objective, OneToOne, Person} from '../../types'
import type {TabbedContentItem} from '../../types'
import TabbedContent from '@/Components/TabbedContent.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'

defineProps<{
    active: TabbedContentItem['identifier'],
    manager: Pick<Person, 'id'|'full_name'>,
    upcomingOneToOnes: OneToOne[],
    previousOneToOnes: OneToOne[],
    objectives: Objective[]
}>()

const breadcrumbs: Breadcrumb[] = [
    {
        display: 'Performance'
    }
]

const tabs: TabbedContentItem[] = [
    {
        identifier: 'request',
        icon: 'UsersIcon',
        display: 'Request a One-to-one'
    },
    {
        identifier: 'upcoming',
        icon: 'ChatBubbleOvalLeftIcon',
        display: 'Upcoming One-to-ones'
    },
    {
        identifier: 'previous',
        icon: 'ChatBubbleOvalLeftEllipsisIcon',
        display: 'Previous One-to-ones'
    },
    {
        identifier: 'current',
        icon: 'CheckCircleIcon',
        display: 'Current Objectives'
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
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        class="pt-8 px-8"
    />
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
        <Current
            v-if="isActive('current')"
            :objectives="objectives"
            @set-active="setActive"
        />
    </TabbedContent>
</template>