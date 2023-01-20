import {computed} from 'vue'
import {usePage} from '@inertiajs/vue3'
import type {OpenHRPageProps} from '../types'
import {isUserPageProp} from '../types'
import {router} from '@inertiajs/vue3'

export default () => {
    return computed(() => {
        const props: unknown = usePage().props
        const user = (props as OpenHRPageProps).auth.user

        if (! isUserPageProp(user)) {
            router.visit('/login')
            throw new Error('No authenticated user')
        }

        return user
    })
}