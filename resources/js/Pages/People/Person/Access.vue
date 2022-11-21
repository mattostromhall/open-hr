<script setup lang="ts">
import {computed} from 'vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import EmailInput from '@/Components/Controls/EmailInput.vue'
import MultiSelectInput from '@/Components/Controls/MultiSelectInput.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import RedButton from '@/Components/Controls/RedButton.vue'
import GreyOutlineButton from '@/Components/Controls/GreyOutlineButton.vue'
import ToggleInput from '@/Components/Controls/ToggleInput.vue'
import {useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import {Inertia} from '@inertiajs/inertia'
import SimpleModal from '@/Components/SimpleModal.vue'
import type {Ref} from 'vue'
import {ref} from 'vue'
import {ExclamationTriangleIcon} from '@heroicons/vue/24/outline'
import type {Person, Role, User} from '../../../types'

const props = defineProps<{
    person: Pick<Person, 'id'|'full_name'>,
    user: Pick<User, 'id'|'email'|'active'>,
    roles: Role[],
    allRoles: Role[]
}>()

interface UpdateEmailForm {
    email: string
}

interface UpdateActiveForm {
    active: boolean
}

interface UpdateRolesForm {
    roles: string[]
}

const emailForm: InertiaForm<UpdateEmailForm> = useForm({
    email: props.user.email
})

const activeForm: InertiaForm<UpdateActiveForm> = useForm({
    active: props.user.active
})

const rolesForm: InertiaForm<UpdateRolesForm> = useForm({
    roles: props.roles.map(role => role.name)
})

const updateEmail = () => {
    emailForm.patch(`/users/${props.user.id}/update-email`)
}

const updateActive = () => {
    activeForm.patch(`/users/${props.user.id}/update-active`)
}

const updateRoles = () => {
    rolesForm.post(`/users/${props.user.id}/roles`)
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

const abilities = computed(() => {
    return new Set(
        props.allRoles.filter(role => rolesForm.roles.includes(role.name))
            .flatMap(role => role.abilities)
            .map(ability => ability.title)
    )
})

const showDeleteModal: Ref<boolean> = ref(false)

function deletePerson() {
    return Inertia.delete(`/people/${props.person.id}`)
}
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
        <form @submit.prevent="updateRoles">
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
                                v-model="rolesForm.roles"
                                :error="rolesForm.errors.roles"
                                :options="roleOptions"
                                input-id="roles"
                                input-name="roles"
                                @reset="rolesForm.clearErrors('roles')"
                            />
                        </div>
                        <p class="mt-3 space-x-1 text-sm text-gray-500">
                            Grants the following abilities:
                            <span
                                v-for="ability in abilities"
                                :key="ability"
                                class="inline-flex px-2 text-xs font-semibold leading-5 text-indigo-800 bg-indigo-100 rounded-full"
                            >
                                {{ ability }}
                            </span>
                        </p>
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
        <form @submit.prevent="deletePerson">
            <div class="shadow sm:rounded-md">
                <div class="py-6 px-4 space-y-6 bg-white sm:p-6 sm:rounded-t-md">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Delete
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Remove the person from the system.
                        </p>
                    </div>
                </div>
                <div class="flex justify-end py-3 px-4 text-right bg-gray-50 sm:px-6 sm:rounded-b-md">
                    <RedButton
                        type="button"
                        @click="showDeleteModal = true"
                    >
                        Delete
                    </RedButton>
                    <SimpleModal
                        v-model="showDeleteModal"
                        modal-classes="px-4 pt-5 pb-4 text-left sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                    >
                        <form @submit.prevent="deletePerson">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <ExclamationTriangleIcon class="h-6 w-6 text-red-600" />
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3
                                        id="modal-title"
                                        class="text-lg font-medium leading-6 text-gray-900"
                                    >
                                        Confirm Delete
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            Are you sure you want to delete {{ person.full_name }}? This action cannot be undone.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                <RedButton class="w-full sm:w-auto sm:ml-3">
                                    Confirm
                                </RedButton>
                                <GreyOutlineButton
                                    class="w-full sm:w-auto mt-3 sm:mt-0"
                                    @click="showDeleteModal = false"
                                >
                                    Cancel
                                </GreyOutlineButton>
                            </div>
                        </form>
                    </SimpleModal>
                </div>
            </div>
        </form>
    </div>
</template>