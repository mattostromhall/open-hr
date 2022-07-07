import {computed} from 'vue'
import {usePage} from '@inertiajs/inertia-vue3'
import type {OpenHRPageProps} from '../types'
import {isPersonPageProp} from '../types'
import {Inertia} from '@inertiajs/inertia'

export default () => {
    return computed(() => {
        const person = usePage<OpenHRPageProps>().props.value.auth.person

        if (! isPersonPageProp(person)) {
            Inertia.visit('/login')
            throw new Error('No authenticated person')
        }

        return person
    })
}