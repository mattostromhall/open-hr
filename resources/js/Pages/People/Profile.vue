<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import {KeyIcon, UserCircleIcon} from '@heroicons/vue/outline'
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
    },
    person: {
        type: Object,
        required: true
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
        onFinish: () => passwordForm.reset('current_password', 'password', 'password_confirmation')
    })
}
</script>

<template>
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

        <div
            v-if="isActive('personal')"
            class="space-y-6 sm:px-6 sm:w-full sm:max-w-3xl lg:col-span-9 lg:px-0"
        >
            <form
                action="#"
                method="POST"
            >
                <div class="shadow sm:overflow-hidden sm:rounded-md">
                    <div class="py-6 px-4 space-y-6 bg-white sm:p-6">
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Personal Information
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Use a permanent address where you can recieve mail.
                            </p>
                        </div>

                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label
                                    for="first-name"
                                    class="block text-sm font-medium text-gray-700"
                                >First name</label>
                                <input
                                    id="first-name"
                                    type="text"
                                    name="first-name"
                                    autocomplete="given-name"
                                    class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm sm:text-sm"
                                >
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label
                                    for="last-name"
                                    class="block text-sm font-medium text-gray-700"
                                >Last name</label>
                                <input
                                    id="last-name"
                                    type="text"
                                    name="last-name"
                                    autocomplete="family-name"
                                    class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm sm:text-sm"
                                >
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label
                                    for="email-address"
                                    class="block text-sm font-medium text-gray-700"
                                >Email address</label>
                                <input
                                    id="email-address"
                                    type="text"
                                    name="email-address"
                                    autocomplete="email"
                                    class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm sm:text-sm"
                                >
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label
                                    for="country"
                                    class="block text-sm font-medium text-gray-700"
                                >Country</label>
                                <select
                                    id="country"
                                    name="country"
                                    autocomplete="country-name"
                                    class="block py-2 px-3 mt-1 w-full bg-white rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm sm:text-sm"
                                >
                                    <option>United States</option>
                                    <option>Canada</option>
                                    <option>Mexico</option>
                                </select>
                            </div>

                            <div class="col-span-6">
                                <label
                                    for="street-address"
                                    class="block text-sm font-medium text-gray-700"
                                >Street address</label>
                                <input
                                    id="street-address"
                                    type="text"
                                    name="street-address"
                                    autocomplete="street-address"
                                    class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm sm:text-sm"
                                >
                            </div>

                            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                <label
                                    for="city"
                                    class="block text-sm font-medium text-gray-700"
                                >City</label>
                                <input
                                    id="city"
                                    type="text"
                                    name="city"
                                    autocomplete="address-level2"
                                    class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm sm:text-sm"
                                >
                            </div>

                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                <label
                                    for="region"
                                    class="block text-sm font-medium text-gray-700"
                                >State / Province</label>
                                <input
                                    id="region"
                                    type="text"
                                    name="region"
                                    autocomplete="address-level1"
                                    class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm sm:text-sm"
                                >
                            </div>

                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                <label
                                    for="postal-code"
                                    class="block text-sm font-medium text-gray-700"
                                >ZIP / Postal code</label>
                                <input
                                    id="postal-code"
                                    type="text"
                                    name="postal-code"
                                    autocomplete="postal-code"
                                    class="block py-2 px-3 mt-1 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm sm:text-sm"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="py-3 px-4 text-right bg-gray-50 sm:px-6">
                        <button
                            type="submit"
                            class="inline-flex justify-center py-2 px-4 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md border border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-sm"
                        >
                            Save
                        </button>
                    </div>
                </div>
            </form>

            <form
                action="#"
                method="POST"
            >
                <div class="shadow sm:overflow-hidden sm:rounded-md">
                    <div class="py-6 px-4 space-y-6 bg-white sm:p-6">
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Notifications
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Provide basic informtion about the job. Be specific with the job title.
                            </p>
                        </div>

                        <fieldset>
                            <legend class="text-base font-medium text-gray-900">
                                By Email
                            </legend>
                            <div class="mt-4 space-y-4">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input
                                            id="comments"
                                            name="comments"
                                            type="checkbox"
                                            class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500"
                                        >
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label
                                            for="comments"
                                            class="font-medium text-gray-700"
                                        >Comments</label>
                                        <p class="text-gray-500">
                                            Get notified when someones posts a comment on a posting.
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input
                                                id="candidates"
                                                name="candidates"
                                                type="checkbox"
                                                class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500"
                                            >
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label
                                                for="candidates"
                                                class="font-medium text-gray-700"
                                            >Candidates</label>
                                            <p class="text-gray-500">
                                                Get notified when a candidate applies for a job.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input
                                                id="offers"
                                                name="offers"
                                                type="checkbox"
                                                class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500"
                                            >
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label
                                                for="offers"
                                                class="font-medium text-gray-700"
                                            >Offers</label>
                                            <p class="text-gray-500">
                                                Get notified when a candidate accepts or rejects an offer.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="mt-6">
                            <legend class="text-base font-medium text-gray-900">
                                Push Notifications
                            </legend>
                            <p class="text-sm text-gray-500">
                                These are delivered via SMS to your mobile phone.
                            </p>
                            <div class="mt-4 space-y-4">
                                <div class="flex items-center">
                                    <input
                                        id="push-everything"
                                        name="push-notifications"
                                        type="radio"
                                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                    >
                                    <label
                                        for="push-everything"
                                        class="ml-3"
                                    >
                                        <span class="block text-sm font-medium text-gray-700">Everything</span>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input
                                        id="push-email"
                                        name="push-notifications"
                                        type="radio"
                                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                    >
                                    <label
                                        for="push-email"
                                        class="ml-3"
                                    >
                                        <span class="block text-sm font-medium text-gray-700">Same as email</span>
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input
                                        id="push-nothing"
                                        name="push-notifications"
                                        type="radio"
                                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                    >
                                    <label
                                        for="push-nothing"
                                        class="ml-3"
                                    >
                                        <span class="block text-sm font-medium text-gray-700">No push notifications</span>
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="py-3 px-4 text-right bg-gray-50 sm:px-6">
                        <button
                            type="submit"
                            class="inline-flex justify-center py-2 px-4 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md border border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 shadow-sm"
                        >
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
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