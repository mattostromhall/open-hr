import {computed} from 'vue'
import {usePage} from '@inertiajs/vue3'
import type {OpenHRPageProps} from '../types'
import {isPersonPageProp} from '../types'
import {router} from '@inertiajs/vue3'

export default () => {
    return computed(() => {
        const props: unknown = usePage().props
        const person = (props as OpenHRPageProps).auth.person

        if (! isPersonPageProp(person)) {
            router.visit('/login')
            throw new Error('No authenticated person')
        }

        return person
    })
}