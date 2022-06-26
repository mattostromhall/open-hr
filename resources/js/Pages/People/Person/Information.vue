<script setup lang="ts">
import EmailInput from '@/Components/Controls/EmailInput.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import PhoneInput from '@/Components/Controls/PhoneInput.vue'
import {useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import type {ComplexSelectOption, Currency, Department, Person} from '../../../types'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import DateInput from '@/Components/Controls/DateInput.vue'
import SelectInput from '@/Components/Controls/SelectInput.vue'
import NumberInput from '@/Components/Controls/NumberInput.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'

const props = defineProps<{
    person: Person,
    people: (Pick<Person, 'id'|'full_name'>)[],
    departments: Department[]
}>()

type InformationData = Omit<Person, 'id'|'user_id'|'full_name'>

const departmentOptions = props.departments.map(department => {
    return {
        value: department.id,
        display: department.name
    }
})

const managerOptions = props.people.map(person => {
    return {
        value: person.id,
        display: person.full_name
    }
})

const remunerationIntervalOptions: ComplexSelectOption[] = [
    {value: 'hourly', display: 'Hourly'},
    {value: 'daily', display: 'Daily'},
    {value: 'weekly', display: 'Weekly'},
    {value: 'monthly', display: 'Monthly'},
    {value: 'yearly', display: 'Yearly'}
]

const remunerationCurrencies: Currency[] = ['GBP', 'EUR', 'USD']

const form: InertiaForm<InformationData> = useForm({
    first_name: props.person.first_name,
    last_name: props.person.last_name,
    dob: props.person.dob,
    position: props.person.position,
    remuneration: props.person.remuneration,
    remuneration_interval: props.person.remuneration_interval,
    remuneration_currency: props.person.remuneration_currency,
    base_holiday_allocation: props.person.base_holiday_allocation,
    holiday_carry_allocation: props.person.holiday_carry_allocation,
    holiday_carried: props.person.holiday_carried,
    sickness_allocation: props.person.sickness_allocation,
    contact_number: props.person.contact_number,
    contact_email: props.person.contact_email,
    started_on: props.person.started_on,
    title: props.person.title,
    initials: props.person.initials,
    pronouns: props.person.pronouns,
    manager_id: props.person.manager_id,
    department_id: props.person.department_id,
    finished_on: props.person.finished_on
})

function submit(): void {
    form.put(`/person/${props.person.id}`)
}
</script>

<template>
    <div class="space-y-6 sm:px-6 sm:w-full sm:max-w-3xl lg:col-span-9 lg:px-0">
        <form @submit.prevent="submit">
            <div class="shadow sm:overflow-hidden sm:rounded-md">
                <div class="py-6 px-4 space-y-6 bg-white sm:p-6">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Person Information
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Review {{ person.full_name }}'s details below.
                        </p>
                    </div>
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
                        <div class="col-span-6 sm:col-span-4">
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
                    </div>
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Department</FormLabel>
                            <div class="mt-1">
                                <SelectInput
                                    v-model="form.department_id"
                                    :error="form.errors.department_id"
                                    input-id="department_id"
                                    input-name="department_id"
                                    :options="departmentOptions"
                                    placeholder-value="Choose a department"
                                    @reset="form.clearErrors('department_id')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Manager</FormLabel>
                            <div class="mt-1">
                                <SelectInput
                                    v-model="form.manager_id"
                                    :error="form.errors.manager_id"
                                    input-id="manager_id"
                                    input-name="manager_id"
                                    :options="managerOptions"
                                    placeholder-value="Choose a manager"
                                    @reset="form.clearErrors('manager_id')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
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
                    </div>
                    <div class="grid grid-cols-6 gap-6">
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
                        <div class="col-span-6 sm:col-span-2">
                            <FormLabel>Base holiday allocation <RequiredIcon /></FormLabel>
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
                        <div class="col-span-6 sm:col-span-2">
                            <FormLabel>Holiday carry allocation <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <NumberInput
                                    v-model.number="form.holiday_carry_allocation"
                                    :error="form.errors.holiday_carry_allocation"
                                    input-id="holiday_carry_allocation"
                                    input-name="holiday_carry_allocation"
                                    @reset="form.clearErrors('holiday_carry_allocation')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <FormLabel>Holiday carried</FormLabel>
                            <div class="mt-1">
                                <NumberInput
                                    v-model.number="form.holiday_carried"
                                    :error="form.errors.holiday_carried"
                                    input-id="holiday_carried"
                                    input-name="holiday_carried"
                                    @reset="form.clearErrors('holiday_carried')"
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
                        <div class="col-span-6 sm:col-span-3">
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
                        <div class="col-span-6 sm:col-span-4">
                            <FormLabel>Finish date</FormLabel>
                            <div class="mt-1">
                                <DateInput
                                    v-model="form.finished_on"
                                    :error="form.errors.finished_on"
                                    input-id="finished_on"
                                    input-name="finished_on"
                                    :base-start-on="form.started_on"
                                    @reset="form.clearErrors('finished_on')"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end py-3 px-4 text-right bg-gray-50 sm:px-6">
                    <IndigoButton
                        :disabled="form.processing"
                    >
                        Submit
                    </IndigoButton>
                </div>
            </div>
        </form>
    </div>
</template>