<script setup lang="ts">
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
import NumberInput from '@/Components/Controls/NumberInput.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'

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
    base_holiday_allocation: number,
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
    {value: 'hourly', display: 'Hourly'},
    {value: 'daily', display: 'Daily'},
    {value: 'weekly', display: 'Weekly'},
    {value: 'monthly', display: 'Monthly'},
    {value: 'yearly', display: 'Yearly'}
]

const remunerationCurrencies: Currency[] = ['GBP', 'EUR', 'USD']

const form: InertiaForm<PersonData> = useForm({
    user_id: props.user.id,
    first_name: '',
    last_name: '',
    dob: '',
    position: '',
    remuneration: 0,
    remuneration_interval: 'yearly',
    remuneration_currency: 'GBP',
    base_holiday_allocation: 25,
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
                    <FormLabel>Remuneration <RequiredIcon /></FormLabel>
                    <div class="mt-1">
                        <NumberInput
                            v-model.number="form.remuneration"
                            :error="form.errors.remuneration"
                            input-id="remuneration"
                            input-name="remuneration"
                            @reset="form.clearErrors('remuneration')"
                        />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                    <FormLabel>Remuneration interval <RequiredIcon /></FormLabel>
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
                    <FormLabel>Remuneration currency <RequiredIcon /></FormLabel>
                    <div class="mt-1">
                        <SelectInput
                            v-model="form.remuneration_currency"
                            :error="form.errors.remuneration_currency"
                            input-id="remuneration_currency"
                            input-name="remuneration_currency"
                            :options="remunerationCurrencies"
                            @reset="form.clearErrors('remuneration_currency')"
                        />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <FormLabel>Base Holiday allocation <RequiredIcon /></FormLabel>
                    <div class="mt-1">
                        <NumberInput
                            v-model.number="form.base_holiday_allocation"
                            :error="form.errors.base_holiday_allocation"
                            input-id="base_holiday_allocation"
                            input-name="base_holiday_allocation"
                            @reset="form.clearErrors('base_holiday_allocation')"
                        />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <FormLabel>Sickness allocation <RequiredIcon /></FormLabel>
                    <div class="mt-1">
                        <NumberInput
                            v-model.number="form.sickness_allocation"
                            :error="form.errors.sickness_allocation"
                            input-id="sickness_allocation"
                            input-name="sickness_allocation"
                            @reset="form.clearErrors('sickness_allocation')"
                        />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <FormLabel>Start date <RequiredIcon /></FormLabel>
                    <div class="mt-1">
                        <DateInput
                            v-model="form.started_on"
                            :error="form.errors.started_on"
                            input-id="started_on"
                            input-name="started_on"
                            @reset="form.clearErrors('started_on')"
                        />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <FormLabel>Contact number <RequiredIcon /></FormLabel>
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
                <div
                    v-if="!sameEmail"
                    class="col-span-6 sm:col-span-3"
                >
                    <FormLabel>Contact email <RequiredIcon /></FormLabel>
                    <div class="mt-1">
                        <EmailInput
                            v-model="form.contact_email"
                            :error="form.errors.contact_email"
                            input-id="contact_email"
                            input-name="contact_email"
                            @reset="form.clearErrors('contact_email')"
                        />
                    </div>
                </div>
                <div class="col-span-6">
                    <FormLabel>Contact email same as email address?</FormLabel>
                    <div class="mt-1">
                        <ToggleInput v-model="sameEmail" />
                    </div>
                </div>
            </div>
        </div>
        <div>
            <IndigoButton :disabled="form.processing">
                Complete
            </IndigoButton>
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