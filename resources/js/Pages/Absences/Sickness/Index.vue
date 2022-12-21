<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import type {Breadcrumb, Sickness, TabbedContentItem} from '../../../types'
import TabbedContent from '@/Components/TabbedContent.vue'
import LogSickness from './LogSickness.vue'
import Sicknesses from './Sicknesses.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'

defineProps<{
    active: TabbedContentItem['identifier'],
    sicknesses: (Pick<Sickness, 'id' | 'start_at' | 'finish_at'> & {duration: number})[]
}>()

const breadcrumbs: Breadcrumb[] = [
    {
        display: 'Sick Days'
    }
]

const tabs: TabbedContentItem[] = [
    {
        identifier: 'log',
        icon: 'ClockIcon',
        display: 'Log a Sick day'
    },
    {
        identifier: 'sicknesses',
        icon: 'FaceFrownIcon',
        display: 'Sicknesses this year'
    }
]
</script>

<template>
    <Head>
        <title>Manage Sicknesses</title>
    </Head>

    <PageHeading>
        Sicknesses
        <template #link>
            <LightIndigoLink href="/sicknesses/calendar">
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
        <LogSickness
            v-if="isActive('log')"
            @set-active="setActive"
        />
        <Sicknesses
            v-if="isActive('sicknesses')"
            :sicknesses="sicknesses"
        />
    </TabbedContent>
</template>