import {computed} from 'vue'
import {usePage} from '@inertiajs/inertia-vue3'
import type {Ability, OpenHRPageProps, Role} from '../types'

export default () => {
    const permissions = usePage<OpenHRPageProps>().props.value.permissions

    function roles() {
        return computed(() => {
            return permissions.roles
        })
    }

    function abilities() {
        return computed(() => {
            return permissions.abilities
        })
    }

    function isA(role: string): boolean {
        return !! roles().value?.find((assignedRole: Role) =>
            assignedRole.name === 'admin'
            || assignedRole.name === role
            || assignedRole.title === role
        )
    }

    function isAn(role: string): boolean {
        return isA(role)
    }

    function can(ability: string): boolean {
        return !! abilities().value?.find((assignedAbility: Ability) =>
            assignedAbility.name === '*'
            || assignedAbility.name === ability
            || assignedAbility.title === ability
        )
    }

    return {roles, abilities, isA, isAn, can}
}

