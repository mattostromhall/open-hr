<script setup lang="ts">
import type {ContractType, SelectOption, Vacancy} from '../../../types'
import {useForm} from '@inertiajs/vue3'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import DateInput from '@/Components/Controls/DateInput.vue'
import NumberInput from '@/Components/Controls/NumberInput.vue'
import EditorInput from '@/Components/Controls/EditorInput.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import SelectInput from '@/Components/Controls/SelectInput.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import currencies from '../../../Shared/currencies'

defineProps<{
    contacts: SelectOption[],
    contractTypes: ContractType[]
}>()

type VacancyData = Omit<Vacancy, 'id' | 'contact_id' | 'public_id'> & {contact_id?: number}

const emit = defineEmits(['setActive'])

const form = useForm<VacancyData>({
    contact_id: undefined,
    title: '',
    description: '',
    location: undefined,
    contract_type: undefined,
    contract_length: undefined,
    remuneration: undefined,
    remuneration_currency: undefined,
    open_at: undefined,
    close_at: undefined
})

function submit() {
    form.post('/vacancies', {
        onSuccess: () => {
            emit('setActive', 'open')
            form.reset()
        }
    })
}
</script>

<template>
    <div class="space-y-6 sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0">
        <form @submit.prevent="submit">
            <div class="shadow sm:rounded-md">
                <div class="space-y-6 bg-white py-6 px-4 sm:rounded-t-md sm:p-6">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Post a Vacancy
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Post a Vacancy for your Organisation.
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