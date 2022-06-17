import {computed} from 'vue'
import {usePage} from '@inertiajs/inertia-vue3'
import type {OpenHRPageProps} from '../types'
import {isNotificationsPageProp} from '../types'

export default () => {
    return computed(() => {
        const notifications = usePage<OpenHRPageProps>().props.value.notifications

        if (! isNotificationsPageProp(notifications)) {
            throw new Error('Incompatible notifications returned.')
        }

        return notifications
    })
}