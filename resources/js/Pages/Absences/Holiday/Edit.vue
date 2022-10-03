<script setup lang="ts">
import {useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import type {Holiday} from '../../../types'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import DateInput from '@/Components/Controls/DateInput.vue'
import TextAreaInput from '@/Components/Controls/TextAreaInput.vue'
import SelectInput from '@/Components/Controls/SelectInput.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'

const props = defineProps<{
    holiday: Holiday,
    requester: string
}>()

type UpdateHolidayData = Omit<Holiday, 'id'>

const halfDayOptions = [
    {value: 'am', display: 'AM'},
    {value: 'pm', display: 'PM'}
]

const form: InertiaForm<UpdateHolidayData> = useForm({
    person_id: props.holiday.person_id,
    status: props.holiday.status,
    start_at: props.holiday.start_at,
    finish_at: props.holiday.finish_at,
    half_day: props.holiday.half_day ?? undefined,
    notes: props.holiday.notes ?? undefined
})

function submit(): void {
    if (form.half_day) {
        form.finish_at = form.start_at
    }

    form.put(`/holidays/${props.holiday.id}`)
}
</script>

<template>
    <Head>
        <title>Edit Holiday</title>
    </Head>

    <PageHeading>
        <span class="font-medium">Editing</span> - Holiday request by {{ requester }}
        <template #link>
            <LightIndigoLink :href="`/holidays/${holiday.id}`">
                View
            </LightIndigoLink>
        </template>
    </PageHeading>
    <div class="space-y-6 p-8 sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9">
        <form @submit.prevent="submit">
            <div class="shadow sm:rounded-md">
                <div class="space-y-6 bg-white py-6 px-4 sm:rounded-t-md sm:p-6">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Update holiday request
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Submit an amended holiday request to your manager.
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
                        <div
                            v-if="! form.half_day"
                            class="col-span-6 sm:col-span-4"
                        >
                            <FormLabel>Finish at <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <DateInput
                                    v-model="form.finish_at"
                                    :error="form.errors.finish_at"
                                    input-id="finish_at"
                                    input-name="finish_at"
                                    :base-start-on="form.start_at"
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
                                    placeholder="Select an option for Half day..."
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