import {computed} from 'vue'
import {usePage} from '@inertiajs/inertia-vue3'
import type {OpenHRPageProps} from '../types'

export default () => {
    return computed(() => usePage<OpenHRPageProps>().props.value.user)
}