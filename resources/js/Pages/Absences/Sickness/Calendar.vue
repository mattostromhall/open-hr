<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import '@fullcalendar/core/vdom'
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import type {EventClickArg} from '@fullcalendar/common'
import CalendarEvent from '@/Components/CalendarEvent.vue'
import useCalendarSlideOver from '../../../Composables/useCalendarSlideOver'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import type {Breadcrumb, SicknessEvent} from '../../../types'
import usePermissions from '../../../Hooks/usePermissions'

const props = defineProps<{
    sicknessEvents: SicknessEvent[]
}>()

const {isA} = usePermissions()

const breadcrumbs: Breadcrumb[] = [
    {
        link: '/sicknesses',
        display: 'Sicknesses'
    },
    {
        display: 'Calendar'
    }
]

const {showCalendarEvent} = useCalendarSlideOver()

const calendarOptions = {
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    headerToolbar: {
        start: 'dayGridMonth,dayGridWeek',
        center: 'title',
        end: 'today prev,next prevYear,nextYear'
    },
    events: props.sicknessEvents,
    displayEventTime: false,
    weekends: false,
    eventClick: ({event}: EventClickArg) => showCalendarEvent(event._def.extendedProps)
}
</script>

<template>
    <Head>
        <title>Sickness Calendar</title>
    </Head>

    <PageHeading>
        Sickness Calendar
        <template #link>
            <LightIndigoLink
                v-if="isA('manager')"
                href="/sicknesses/manage"
            >
                Manage Sicknesses
            </LightIndigoLink>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        class="pt-8 px-8"
    />
    <section class="p-8">
        <FullCalendar :options="calendarOptions" />
    </section>
    <CalendarEvent />
</template>