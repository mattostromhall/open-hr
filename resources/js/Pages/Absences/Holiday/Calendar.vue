<script setup lang="ts">
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import type {EventClickArg} from '@fullcalendar/common'
import CalendarEvent from '@/Components/CalendarEvent.vue'
import useCalendarSlideOver from '../../../Composables/useCalendarSlideOver'

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
    headerToolbar: { center: 'dayGridMonth,dayGridWeek' },
    events: props.holidayEvents,
    displayEventTime: false,
    nextDayThreshold: '12:00:00',
    weekends: false,
    eventClick: ({event}: EventClickArg) => showCalendarEvent(event._def.extendedProps)
}
</script>

<template>
    <section class="p-8">
        <FullCalendar :options="calendarOptions" />
    </section>
    <CalendarEvent />
</template>