import {computed} from 'vue'
import {usePage} from '@inertiajs/inertia-vue3'
import type {OpenHRPageProps} from '../types'

export default () => {
    return computed(() => {
        return usePage<OpenHRPageProps>().props.value.impersonating
    })
}