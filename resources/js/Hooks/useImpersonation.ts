import {computed} from 'vue'
import {usePage} from '@inertiajs/vue3'
import type {OpenHRPageProps} from '../types'

export default () => {
    return computed(() => {
        const props: unknown = usePage().props
        return (props as OpenHRPageProps).impersonating
    })
}