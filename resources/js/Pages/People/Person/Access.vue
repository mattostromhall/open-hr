<script setup lang="ts">
import {computed} from 'vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import EmailInput from '@/Components/Controls/EmailInput.vue'
import MultiSelectInput from '@/Components/Controls/MultiSelectInput.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import ToggleInput from '@/Components/Controls/ToggleInput.vue'
import {useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import type {Ability, Role, User} from '../../../types'

const props = defineProps<{
    user: Pick<User, 'id'|'email'|'active'>,
    roles: Role[],
    abilities: Ability[],
    allRoles: Role[],
    allAbilities: Ability[]
}>()

interface UpdateEmailForm {
    email: string
}

interface UpdateActiveForm {
    active: boolean
}

const emailForm: InertiaForm<UpdateEmailForm> = useForm({
    email: props.user.email
})

const activeForm: InertiaForm<UpdateActiveForm> = useForm({
    active: props.user.active
})

const permissionsForm = useForm({
    roles: props.roles.map(role => role.name),
    abilities: props.abilities.map(ability => ability.name)
})

const updateEmail = () => {
    emailForm.patch(`/users/${props.user.id}/update-email`)
}

const updateActive = () => {
    activeForm.patch(`/users/${props.user.id}/update-active`)
}

const roleOptions = computed(() =>
    props.allRoles
        .map(role => {
            return {
                value: role.name,
                display: role.title
            }
        })
)

const abilityOptions = computed(() => {
    if (props.abilities.find(ability => ability.name === '*')) {
        return [{
            value: '*',
            display: 'All abilities'
        }]
    }

    return props.allAbilities
        .map(ability => {
            return {
                value: ability.name,
                display: ability.title
            }
        })
})
</script>

<template>
    <div class="space-y-6 sm:px-6 sm:w-full sm:max-w-3xl lg:col-span-9 lg:px-0">
        <form @submit.prevent="updateEmail">
            <div class="shadow sm:rounded-md">
                <div class="py-6 px-4 space-y-6 bg-white sm:p-6 sm:rounded-t-md">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Email
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Manage the email address associated with the account.
                        </p>
                    </div>
                    <div>
                        <FormLabel>Email</FormLabel>
                        <div class="mt-1">
                            <EmailInput
                                v-model="emailForm.email"
                                :error="emailForm.errors.email"
                                input-id="email"
                                input-name="email"
                                @reset="emailForm.clearErrors('email')"
                            />
                        </div>
                    </div>
                </div>
                <div class="flex justify-end py-3 px-4 text-right bg-gray-50 sm:px-6 sm:rounded-b-md">
                    <IndigoButton
                        :disabled="emailForm.processing"
                    >
                        Save
                    </IndigoButton>
                </div>
            </div>
        </form>
        <form @submit.prevent="updateActive">
            <div class="shadow sm:rounded-md">
                <div class="py-6 px-4 space-y-6 bg-white sm:p-6 sm:rounded-t-md">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Active
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Set whether the person can access the system.
                        </p>
                    </div>
                    <div class="mt-4">
                        <FormLabel>Active</FormLabel>
                        <div class="mt-1">
                            <ToggleInput v-model="activeForm.active" />
                        </div>
                    </div>
                </div>
                <div class="flex justify-end py-3 px-4 text-right bg-gray-50 sm:px-6 sm:rounded-b-md">
                    <IndigoButton
                        :disabled="activeForm.processing"
                    >
                        Save
                    </IndigoButton>
                </div>
            </div>
        </form>
        <form @submit.prevent="updateActive">
            <div class="shadow sm:rounded-md">
                <div class="py-6 px-4 space-y-6 bg-white sm:p-6 sm:rounded-t-md">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Roles and Abilities
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Control what access the person has to the system.
                        </p>
                    </div>
                    <div class="mt-1">
                        <FormLabel>Roles</FormLabel>
                        <div class="mt-1">
                            <MultiSelectInput
                                v-model="permissionsForm.roles"
                                :error="permissionsForm.errors.roles"
                                :options="roleOptions"
                                input-id="roles"
                                input-name="roles"
                                @reset="permissionsForm.clearErrors('roles')"
                            />
                        </div>
                    </div>
                    <div class="mt-1">
                        <FormLabel>Abilities</FormLabel>
                        <div class="mt-1">
                            <MultiSelectInput
                                v-model="permissionsForm.abilities"
                                :error="permissionsForm.errors.abilities"
                                :options="abilityOptions"
                                input-id="abilities"
                                input-name="abilities"
                                @reset="permissionsForm.clearErrors('abilities')"
                            />
                        </div>
                    </div>
                </div>
                <div class="flex justify-end py-3 px-4 text-right bg-gray-50 sm:px-6 sm:rounded-b-md">
                    <IndigoButton
                        :disabled="activeForm.processing"
                    >
                        Save
                    </IndigoButton>
                </div>
            </div>
        </form>
    </div>
</template>