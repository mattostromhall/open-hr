<script setup lang="ts">
import PasswordInput from '@/Components/Controls/PasswordInput.vue'
import EmailInput from '@/Components/Controls/EmailInput.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import PhoneInput from '@/Components/Controls/PhoneInput.vue'
import {useForm} from '@inertiajs/inertia-vue3'
import {Inertia} from '@inertiajs/inertia'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import ToggleInput from '@/Components/Controls/ToggleInput.vue'
import {ref} from 'vue'
import type {Ref} from 'vue'
import type {ComplexSelectOption, Currency, RecurrenceInterval} from '../../types'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import DateInput from '@/Components/Controls/DateInput.vue'
import SelectInput from '@/Components/Controls/SelectInput.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'

const props = defineProps({
    user: {
        type: Object,
        required: true
    }
})

interface PersonData {
    user_id: number,
    first_name: string,
    last_name: string,
    dob: string,
    position: string,
    remuneration: number,
    remuneration_interval: RecurrenceInterval,
    remuneration_currency: Currency,
    holiday_allocation: number,
    sickness_allocation: number,
    contact_number: string,
    contact_email: string,
    started_on: string,
    manager_id?: number,
    department_id?: number,
    title?: string,
    initials?: string,
    pronouns?: string,
    finished_on?: string
}

const remunerationIntervalOptions: ComplexSelectOption[] = [
    {
        value: 'hourly',
        display: 'Hourly'
    },
    {
        value: 'daily',
        display: 'Daily'
    },
    {
        value: 'weekly',
        display: 'Weekly'
    },
    {
        value: 'monthly',
        display: 'Monthly'
    },
    {
        value: 'yearly',
        display: 'Yearly'
    }
]

const form: InertiaForm<PersonData> = useForm({
    user_id: props.user.id,
    first_name: '',
    last_name: '',
    dob: '',
    position: '',
    remuneration: 0,
    remuneration_interval: 'yearly',
    remuneration_currency: 'GBP',
    holiday_allocation: 25,
    sickness_allocation: 10,
    contact_number: '',
    contact_email: '',
    started_on: '',
    title: '',
    initials: '',
    pronouns: '',
    manager_id: undefined,
    department_id: undefined,
    finished_on: undefined
})

const sameEmail: Ref<boolean> = ref(true)

function submit(): void {
    if (sameEmail.value) {
        form.contact_email = props.user.email
    }

    form.post('/setup/person')
}

function skipStage(): void {
    Inertia.post('/setup')
}
</script>

<template>
    <form
        class="space-y-6"
        @submit.prevent="submit"
    >
        <div class="space-y-6">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <FormLabel>First name <RequiredIcon /></FormLabel>
                    <div class="mt-1">
                        <TextInput
                            v-model="form.first_name"
                            :error="form.errors.first_name"
                            input-id="first_name"
                            input-name="first_name"
                            @reset="form.clearErrors('first_name')"
                        />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <FormLabel>Last name <RequiredIcon /></FormLabel>
                    <div class="mt-1">
                        <TextInput
                            v-model="form.last_name"
                            :error="form.errors.last_name"
                            input-id="last_name"
                            input-name="last_name"
                            @reset="form.clearErrors('last_name')"
                        />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                    <FormLabel>Title</FormLabel>
                    <div class="mt-1">
                        <TextInput
                            v-model="form.title"
                            :error="form.errors.title"
                            input-id="title"
                            input-name="title"
                            @reset="form.clearErrors('title')"
                        />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                    <FormLabel>Initials</FormLabel>
                    <div class="mt-1">
                        <TextInput
                            v-model="form.initials"
                            :error="form.errors.initials"
                            input-id="initials"
                            input-name="initials"
                            @reset="form.clearErrors('initials')"
                        />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                    <FormLabel>Pronouns</FormLabel>
                    <div class="mt-1">
                        <TextInput
                            v-model="form.pronouns"
                            :error="form.errors.pronouns"
                            input-id="pronouns"
                            input-name="pronouns"
                            @reset="form.clearErrors('pronouns')"
                        />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <FormLabel>Date of birth <RequiredIcon /></FormLabel>
                    <div class="mt-1">
                        <DateInput
                            v-model="form.dob"
                            :error="form.errors.dob"
                            input-id="dob"
                            input-name="dob"
                            @reset="form.clearErrors('dob')"
                        />
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-5">
                    <FormLabel>Position <RequiredIcon /></FormLabel>
                    <div class="mt-1">
                        <TextInput
                            v-model="form.position"
                            :error="form.errors.position"
                            input-id="position"
                            input-name="position"
                            @reset="form.clearErrors('position')"
                        />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                    <FormLabel>Remuneration</FormLabel>
                    <div class="mt-1">
                        <TextInput
                            v-model="form.remuneration"
                            :error="form.errors.remuneration"
                            input-id="remuneration"
                            input-name="remuneration"
                            @reset="form.clearErrors('remuneration')"
                        />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                    <FormLabel>Remuneration interval</FormLabel>
                    <div class="mt-1">
                        <SelectInput
                            v-model="form.remuneration_interval"
                            :error="form.errors.remuneration_interval"
                            input-id="remuneration_interval"
                            input-name="remuneration_interval"
                            :options="remunerationIntervalOptions"
                            @reset="form.clearErrors('remuneration_interval')"
                        />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                    <FormLabel>Pronouns</FormLabel>
                    <div class="mt-1">
                        <TextInput
                            v-model="form.pronouns"
                            :error="form.errors.pronouns"
                            input-id="pronouns"
                            input-name="pronouns"
                            @reset="form.clearErrors('pronouns')"
                        />
                    </div>
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
        <div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email address</label>
                <div class="mt-1">
                    <EmailInput
                        v-model="form.email"
                        :error="form.errors.email"
                        input-id="email"
                        input-name="email"
                        @reset="form.clearErrors('email')"
                    />
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <div class="mt-1">
                    <PasswordInput
                        v-model="form.password"
                        :error="form.errors.password"
                        input-id="password"
                        input-name="password"
                        @reset="form.clearErrors('password')"
                    />
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Password confirmation</label>
                <div class="mt-1">
                    <PasswordInput
                        v-model="form.password_confirmation"
                        :error="form.errors.password"
                        input-id="password_confirmation"
                        input-name="password_confirmation"
                        @reset="form.clearErrors('password')"
                    />
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Contact number</label>
                <div class="mt-1">
                    <PhoneInput
                        v-model="form.contact_number"
                        :error="form.errors.contact_number"
                        input-id="contact_number"
                        input-name="contact_number"
                        @reset="form.clearErrors('contact_number')"
                    />
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Contact email same as email address?</label>
                <div class="mt-1">
                    <ToggleInput v-model="sameEmail" />
                </div>
                <div
                    v-if="!sameEmail"
                    class="mt-2"
                >
                    <label class="block text-sm font-medium text-gray-700">Contact email</label>
                    <div class="mt-1">
                        <TextInput
                            v-model="form.contact_email"
                            :error="form.errors.contact_email"
                            input-id="contact_email"
                            input-name="contact_email"
                            @reset="form.clearErrors('contact_email')"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div>
            <button
                type="submit"
                class="flex justify-center py-2 px-4 w-full text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md border border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-sm"
            >
                Next
            </button>
        </div>
    </form>
    <div class="mt-3 text-center">
        <button
            type="button"
            class="text-sm font-semibold text-indigo-600"
            @click="skipStage"
        >
            Skip
        </button>
    </div>
</template>