import {computed} from 'vue'
import {usePage} from '@inertiajs/vue3'
import type {OpenHRPageProps} from '../types'
import {isNotificationsPageProp} from '../types'

export default () => {
    return computed(() => {
        const props: unknown = usePage().props
        const notifications = (props as OpenHRPageProps).notifications

        if (! isNotificationsPageProp(notifications)) {
            throw new Error('Incompatible notifications returned.')
        }

        return notifications
    })
}