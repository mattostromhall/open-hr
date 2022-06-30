<script setup lang="ts">
import FormLabel from '@/Components/Controls/FormLabel.vue'
import EmailInput from '@/Components/Controls/EmailInput.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import ToggleInput from '@/Components/Controls/ToggleInput.vue'
import {useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import type {User} from '../../../types'

const props = defineProps<{
    user: Pick<User, 'id'|'email'|'active'>
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

const updateEmail = () => {
    emailForm.patch(`/users/${props.user.id}/update-email`)
}

const updateActive = () => {
    activeForm.patch(`/users/${props.user.id}/update-active`)
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
    </div>
</template>