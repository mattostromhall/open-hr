import {computed} from 'vue'
import {usePage} from '@inertiajs/inertia-vue3'
import type {OpenHRPageProps} from '../types'
import {isUserPageProp} from '../types'
import {Inertia} from '@inertiajs/inertia'

export default () => {
    return computed(() => {
        const user = usePage<OpenHRPageProps>().props.value.user

        if (! isUserPageProp(user)) {
            Inertia.visit('/login')
            throw new Error('No authenticated user')
        }

        return user
    })
}