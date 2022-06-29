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

const props = defineProps({
    holidayEvents: {
        type: Array,
        default: () => []
    }
})

const {showCalendarEvent} = useCalendarSlideOver()

const calendarOptions = {
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    headerToolbar: {
        start: 'dayGridMonth,dayGridWeek',
        center: 'title',
        end: 'today prev,next prevYear,nextYear'
    },
    events: props.holidayEvents,
    displayEventTime: false,
    nextDayThreshold: '12:00:00',
    weekends: false,
    eventClick: ({event}: EventClickArg) => showCalendarEvent(event._def.extendedProps)
}
</script>

<script lang="ts">
import Main from '@/Layouts/Main.vue'

export default {layout: Main}
</script>

<template>
    <Head title="Holiday Calendar" />

    <PageHeading>
        Holiday Calendar
        <template #link>
            <LightIndigoLink href="/holidays">
                Manage holiday
            </LightIndigoLink>
        </template>
    </PageHeading>

    <section class="p-8">
        <FullCalendar :options="calendarOptions" />
    </section>
    <CalendarEvent />
</template>