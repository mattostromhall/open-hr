<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import {KeyIcon, MailIcon, UserCircleIcon} from '@heroicons/vue/outline'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import EmailInput from '@/Components/Controls/EmailInput.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import PasswordInput from '@/Components/Controls/PasswordInput.vue'
import {Head, useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import PersonalInformation from './PersonalInformation.vue'

const props = defineProps({
    email: {
        type: String,
        default: ''
    },
    person: {
        type: Object,
        required: true
    },
    addresses: {
        type: Array,
        default: () => []
    }
})

const activeTab: Ref<string> = ref('personal')

function setActive(tab: string): void {
    activeTab.value = tab
}

function isActive(tab: string): boolean {
    return activeTab.value === tab
}

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
    <Head title="Profile" />

    <div class="p-8 lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:col-span-3 lg:p-0">
            <nav class="space-y-1">
                <button
                    class="group flex items-center py-2 px-3 w-full text-sm font-medium rounded-md"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('personal'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('personal')
                    }"
                    aria-current="page"
                    @click="setActive('personal')"
                >
                    <UserCircleIcon
                        class="shrink-0 mr-3 -ml-1 w-6 h-6"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('personal'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('personal')
                        }"
                    />
                    <span class="truncate">Personal Information</span>
                </button>
                <button
                    class="group flex items-center py-2 px-3 w-full text-sm font-medium rounded-md"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('addresses'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('addresses')
                    }"
                    aria-current="page"
                    @click="setActive('addresses')"
                >
                    <MailIcon
                        class="shrink-0 mr-3 -ml-1 w-6 h-6"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('addresses'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('addresses')
                        }"
                    />
                    <span class="truncate">Addresses</span>
                </button>
                <button
                    class="group flex items-center py-2 px-3 w-full text-sm font-medium rounded-md"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('credentials'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('credentials')
                    }"
                    @click="setActive('credentials')"
                >
                    <KeyIcon
                        class="shrink-0 mr-3 -ml-1 w-6 h-6"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('credentials'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('credentials')
                        }"
                    />
                    <span class="truncate">Credentials</span>
                </button>
            </nav>
        </aside>
        <PersonalInformation
            v-if="isActive('personal')"
            :person="person"
        />
        <div
            v-if="isActive('credentials')"
            class="space-y-6 sm:px-6 sm:w-full sm:max-w-3xl lg:col-span-9 lg:px-0"
        >
            <form @submit.prevent="updateEmail">
                <div class="shadow sm:overflow-hidden sm:rounded-md">
                    <div class="py-6 px-4 space-y-6 bg-white sm:p-6">
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
                    <div class="flex justify-end py-3 px-4 text-right bg-gray-50 sm:px-6">
                        <IndigoButton
                            :disabled="emailForm.processing"
                        >
                            Save
                        </IndigoButton>
                    </div>
                </div>
            </form>
            <form @submit.prevent="updatePassword">
                <div class="shadow sm:overflow-hidden sm:rounded-md">
                    <div class="py-6 px-4 space-y-6 bg-white sm:p-6">
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
                    <div class="flex justify-end py-3 px-4 text-right bg-gray-50 sm:px-6">
                        <IndigoButton
                            :disabled="passwordForm.processing"
                        >
                            Save
                        </IndigoButton>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>