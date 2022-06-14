<script setup lang="ts">
import {useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import DateInput from '@/Components/Controls/DateInput.vue'
import TextAreaInput from '@/Components/Controls/TextAreaInput.vue'
import SelectInput from '@/Components/Controls/SelectInput.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import usePerson from '../../../Hooks/usePerson'

type HalfDay = 'am' | 'pm'

interface HolidayRequestData {
    person_id: number,
    start_at: string,
    finish_at: string,
    half_day?: HalfDay,
    notes?: string
}

const person = usePerson()

const halfDayOptions = [
    {value: 'am', display: 'AM'},
    {value: 'pm', display: 'PM'}
]

const form: InertiaForm<HolidayRequestData> = useForm({
    person_id: person.value.id,
    start_at: '',
    finish_at: '',
    half_day: undefined,
    notes: undefined
})

function submit(): void {
    if (form.half_day) {
        form.finish_at = form.start_at
    }

    form.post('/holidays')
}
</script>

<template>
    <div class="p-8">
        <div class="space-y-6 sm:px-6 sm:w-full sm:max-w-3xl lg:col-span-9 lg:px-0">
            <form @submit.prevent="submit">
                <div class="shadow sm:overflow-hidden sm:rounded-md">
                    <div class="py-6 px-4 space-y-6 bg-white sm:p-6">
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Request holiday
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Submit a holiday request to your manager.
                            </p>
                        </div>

                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-4">
                                <FormLabel>Start at <RequiredIcon /></FormLabel>
                                <div class="mt-1">
                                    <DateInput
                                        v-model="form.start_at"
                                        :error="form.errors.start_at"
                                        input-id="start_at"
                                        input-name="start_at"
                                        @reset="form.clearErrors('start_at')"
                                    />
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-4">
                                <FormLabel>Finish at <RequiredIcon /></FormLabel>
                                <div class="mt-1">
                                    <DateInput
                                        v-model="form.finish_at"
                                        :error="form.errors.finish_at"
                                        input-id="finish_at"
                                        input-name="finish_at"
                                        @reset="form.clearErrors('finish_at')"
                                    />
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <FormLabel>Half day</FormLabel>
                                <div class="mt-1">
                                    <SelectInput
                                        v-model="form.half_day"
                                        :error="form.errors.half_day"
                                        :options="halfDayOptions"
                                        input-id="half_day"
                                        input-name="half_day"
                                        @reset="form.clearErrors('half_day')"
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
                    <div class="flex justify-end py-3 px-4 text-right bg-gray-50 sm:px-6">
                        <IndigoButton
                            :disabled="form.processing"
                        >
                            Save
                        </IndigoButton>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>