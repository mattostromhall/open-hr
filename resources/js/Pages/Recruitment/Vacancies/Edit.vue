<script setup lang="ts">
import type {Breadcrumb, ContractType, SelectOption, Vacancy} from '../../../types'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import {useForm} from '@inertiajs/inertia-vue3'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import DateInput from '@/Components/Controls/DateInput.vue'
import NumberInput from '@/Components/Controls/NumberInput.vue'
import EditorInput from '@/Components/Controls/EditorInput.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import SelectInput from '@/Components/Controls/SelectInput.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import currencies from '../../../Shared/currencies'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'

const props = defineProps<{
    vacancy: Vacancy,
    contacts: SelectOption[],
    contractTypes: ContractType[]
}>()

const breadcrumbs: Breadcrumb[] = [
    {
        link: '/vacancies?active=open',
        display: 'Vacancies'
    },
    {
        link: `/vacancies/${props.vacancy.id}`,
        display: props.vacancy.title
    }
]

type VacancyData = Omit<Vacancy, 'id' | 'public_id'>

const form: InertiaForm<VacancyData> = useForm({
    contact_id: props.vacancy.contact_id,
    title: props.vacancy.title,
    description: props.vacancy.description,
    location: props.vacancy.location,
    contract_type: props.vacancy.contract_type,
    contract_length: props.vacancy.contract_length,
    remuneration: props.vacancy.remuneration,
    remuneration_currency: props.vacancy.remuneration_currency,
    open_at: props.vacancy.open_at,
    close_at: props.vacancy.close_at
})

function submit() {
    form.put(`/vacancies/${props.vacancy.id}`)
}
</script>

<template>
    <Head>
        <title>Edit Vacancy</title>
    </Head>

    <PageHeading>
        <span class="font-medium">Editing</span> - {{ vacancy.title }}
        <template #link>
            <LightIndigoLink :href="`/vacancies/${vacancy.id}`">
                View
            </LightIndigoLink>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        dashboard="/dashboard/organisation"
        class="pt-8 px-8"
    />
    <div class="space-y-6 p-8 sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9">
        <form @submit.prevent="submit">
            <div class="shadow sm:rounded-md">
                <div class="space-y-6 bg-white py-6 px-4 sm:rounded-t-md sm:p-6">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Update Vacancy
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Update the Posted Vacancy for your Organisation.
                        </p>
                    </div>
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Contact <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <SelectInput
                                    v-model="form.contact_id"
                                    :error="form.errors.contact_id"
                                    :options="contacts"
                                    input-id="contact_id"
                                    input-name="contact_id"
                                    placeholder="Select a Contact..."
                                    @reset="form.clearErrors('contact_id')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <FormLabel>Title <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <TextInput
                                    v-model="form.title"
                                    :error="form.errors.title"
                                    input-id="title"
                                    input-type="title"
                                    @reset="form.clearErrors('title')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-5">
                            <FormLabel>Location</FormLabel>
                            <div class="mt-1">
                                <TextInput
                                    v-model="form.location"
                                    :error="form.errors.location"
                                    input-id="location"
                                    input-type="location"
                                    @reset="form.clearErrors('location')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Contract Type</FormLabel>
                            <div class="mt-1">
                                <SelectInput
                                    v-model="form.contract_type"
                                    :error="form.errors.contract_type"
                                    :options="contractTypes"
                                    input-id="contract_type"
                                    input-name="contract_type"
                                    placeholder="Select a Contract Type..."
                                    @reset="form.clearErrors('contract_type')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Contract Length</FormLabel>
                            <div class="mt-1">
                                <TextInput
                                    v-model="form.contract_length"
                                    :error="form.errors.contract_length"
                                    input-id="contract_length"
                                    input-type="contract_length"
                                    @reset="form.clearErrors('contract_length')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Remuneration</FormLabel>
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
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Remuneration Currency</FormLabel>
                            <div class="mt-1">
                                <SelectInput
                                    v-model="form.remuneration_currency"
                                    :error="form.errors.remuneration_currency"
                                    :options="currencies"
                                    input-id="remuneration_currency"
                                    input-name="remuneration_currency"
                                    placeholder="Select a Currency..."
                                    @reset="form.clearErrors('remuneration_currency')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Open Date</FormLabel>
                            <div class="mt-1">
                                <DateInput
                                    v-model="form.open_at"
                                    :error="form.errors.open_at"
                                    input-id="open_at"
                                    input-name="open_at"
                                    :time-enabled="true"
                                    @reset="form.clearErrors('open_at')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Close Date</FormLabel>
                            <div class="mt-1">
                                <DateInput
                                    v-model="form.close_at"
                                    :error="form.errors.close_at"
                                    input-id="close_at"
                                    input-name="close_at"
                                    :time-enabled="true"
                                    @reset="form.clearErrors('close_at')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6">
                            <FormLabel>Description <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <EditorInput
                                    v-model="form.description"
                                    :error="form.errors.description"
                                    :preview-enabled="true"
                                    @reset="form.clearErrors('description')"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end bg-gray-50 py-3 px-4 text-right sm:rounded-b-md sm:px-6">
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