<script setup lang="ts">
import FormLabel from '@/Components/Controls/FormLabel.vue'
import EmailInput from '@/Components/Controls/EmailInput.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import PasswordInput from '@/Components/Controls/PasswordInput.vue'
import {useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'

const props = defineProps({
    email: {
        type: String,
        default: ''
    }
})

interface UpdateEmailForm {
    email: string
}

interface UpdatePasswordForm {
    current_password: string,
    password: string,
    password_confirmation: string
}

const emailForm: InertiaForm<UpdateEmailForm> = useForm({
    email: props.email
})

const passwordForm: InertiaForm<UpdatePasswordForm> = useForm({
    current_password: '',
    password: '',
    password_confirmation: ''
})

const updateEmail = () => {
    emailForm.patch('/profile/update-email')
}

const updatePassword = () => {
    passwordForm.patch('/profile/update-password', {
        onSuccess: () => passwordForm.reset('current_password', 'password', 'password_confirmation')
    })
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
                            Manage the email address associated with your account.
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
        <form @submit.prevent="updatePassword">
            <div class="shadow sm:rounded-md">
                <div class="py-6 px-4 space-y-6 bg-white sm:p-6 sm:rounded-t-md">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Password
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Manage the password associated with your account.
                        </p>
                    </div>
                    <div class="mt-4">
                        <FormLabel>Current password</FormLabel>
                        <div class="mt-1">
                            <PasswordInput
                                v-model="passwordForm.current_password"
                                :error="passwordForm.errors.current_password"
                                input-id="current_password"
                                input-name="current_password"
                                @reset="passwordForm.clearErrors('current_password')"
                            />
                        </div>
                    </div>
                    <div class="mt-4">
                        <FormLabel>New password</FormLabel>
                        <div class="mt-1">
                            <PasswordInput
                                v-model="passwordForm.password"
                                :error="passwordForm.errors.password"
                                input-id="password"
                                input-name="password"
                                @reset="passwordForm.clearErrors('password')"
                            />
                        </div>
                    </div>
                    <div class="mt-4">
                        <FormLabel>Confirm new password</FormLabel>
                        <div class="mt-1">
                            <PasswordInput
                                v-model="passwordForm.password_confirmation"
                                :error="passwordForm.errors.password"
                                input-id="password_confirmation"
                                input-name="password_confirmation"
                                @reset="passwordForm.clearErrors('password')"
                            />
                        </div>
                    </div>
                </div>
                <div class="flex justify-end py-3 px-4 text-right bg-gray-50 sm:px-6 sm:rounded-b-md">
                    <IndigoButton
                        :disabled="passwordForm.processing"
                    >
                        Save
                    </IndigoButton>
                </div>
            </div>
        </form>
    </div>
</template>