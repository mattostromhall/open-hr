<script setup lang="ts">
import {useForm} from '@inertiajs/vue3'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import TextAreaInput from '@/Components/Controls/TextAreaInput.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import type {Person, Training} from '../../../types'
import NumberInput from '@/Components/Controls/NumberInput.vue'
import SelectInput from '@/Components/Controls/SelectInput.vue'
import SearchableSelectInput from '@/Components/Controls/SearchableSelectInput.vue'
import currencies from '../../../Shared/currencies'
import {computed} from 'vue'
import type {ComputedRef} from 'vue'

type TrainingRequestData = Omit<Training, 'id' | 'person_id'> & {person_id?: number}

const props = defineProps<{
    directReports: (Pick<Person, 'id'|'full_name'>)[]
}>()

const directReportOptions: ComputedRef<({
    value: string | number, display: string | number
})[]> = computed(() => props.directReports.map((directReport) => {
    return {
        value: directReport.id,
        display: directReport.full_name
    }
}))

const form = useForm<TrainingRequestData>({
    person_id: undefined,
    status: 2,
    state: 1,
    description: '',
    provider: '',
    location: undefined,
    cost: undefined,
    cost_currency: undefined,
    duration: undefined,
    notes: undefined
})

function submit(): void {
    form.post('/training', {
        onSuccess: () => form.reset()
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
                            Assign Training
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Assign Training to one of your Direct Reports.
                        </p>
                    </div>
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <FormLabel>Assign to <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <SearchableSelectInput
                                    v-model="form.person_id"
                                    :options="directReportOptions"
                                    :error="form.errors.person_id"
                                    @reset="form.clearErrors('person_id')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-5">
                            <FormLabel>Description <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <TextInput
                                    v-model="form.description"
                                    :error="form.errors.description"
                                    input-id="description"
                                    input-name="description"
                                    @reset="form.clearErrors('description')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Provider <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <TextInput
                                    v-model="form.provider"
                                    :error="form.errors.provider"
                                    input-id="provider"
                                    input-name="provider"
                                    @reset="form.clearErrors('provider')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Location</FormLabel>
                            <div class="mt-1">
                                <TextInput
                                    v-model="form.location"
                                    :error="form.errors.location"
                                    input-id="location"
                                    input-name="location"
                                    @reset="form.clearErrors('location')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <FormLabel>Cost</FormLabel>
                            <div class="mt-1">
                                <NumberInput
                                    v-model="form.cost"
                                    :error="form.errors.cost"
                                    input-id="cost"
                                    input-name="cost"
                                    :step="0.01"
                                    @reset="form.clearErrors('cost')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <FormLabel>Currency</FormLabel>
                            <div class="mt-1">
                                <SelectInput
                                    v-model="form.cost_currency"
                                    :error="form.errors.cost_currency"
                                    input-id="cost_currency"
                                    input-name="cost_currency"
                                    :options="currencies"
                                    @reset="form.clearErrors('cost_currency')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <FormLabel>Duration (days)</FormLabel>
                            <div class="mt-1">
                                <NumberInput
                                    v-model="form.duration"
                                    :error="form.errors.duration"
                                    input-id="duration"
                                    input-name="duration"
                                    @reset="form.clearErrors('duration')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6">
                            <FormLabel>Notes</FormLabel>
                            <div class="mt-1">
                                <TextAreaInput
                                    v-model="form.notes"
                                    :error="form.errors.notes"
                                    input-id="notes"
                                    input-name="notes"
                                    @reset="form.clearErrors('notes')"
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