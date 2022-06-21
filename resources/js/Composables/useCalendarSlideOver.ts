import {ref} from 'vue'
import type {Ref} from 'vue'
import type {Dictionary} from '@fullcalendar/vue3'

const show: Ref<boolean> = ref(false)
const calendarEvent: Ref<Dictionary> = ref({
    start_at: '',
    finish_at: '',
    status: 1,
    person: {
        full_name: ''
    }
})

export default () => {

    function showCalendarEvent(event: Dictionary) {
        calendarEvent.value = event
        show.value = true
    }

    function hideCalendarEvent() {
        show.value = false
    }

    return {show, calendarEvent, showCalendarEvent, hideCalendarEvent}
}