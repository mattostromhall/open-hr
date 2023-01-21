<script setup lang="ts">
import {useForm} from '@inertiajs/vue3'
import type {Person} from '../../../types'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import MultiSelectInput from '@/Components/Controls/MultiSelectInput.vue'

const props = defineProps<{
    person: Person,
    people: (Pick<Person, 'id'|'full_name'>)[],
    directReports: number[]
}>()

const directReportOptions = props.people
    .filter(person => person.id !== props.person.manager_id)
    .map(person => {
        return {
            value: person.id,
            display: person.full_name
        }
    })

const form = useForm<{direct_reports: number[]}>({
    direct_reports: props.directReports
})

function submit(): void {
    form.post(`/people/${props.person.id}/direct-reports`)
}
</script>

<template>
    <div class="space-y-6 sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0">
        <form @submit.prevent="submit">
            <div class="shadow sm:rounded-md">
                <div class="space-y-6 bg-white py-6 px-4 sm:rounded-t-md sm:p-6">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Direct reports
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Manage who reports in to {{ person.full_name }}
                        </p>
                    </div>
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Reports <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <MultiSelectInput
                                    v-model="form.direct_reports"
                                    :error="form.errors.direct_reports"
                                    :options="directReportOptions"
                                    input-id="direct_reports"
                                    input-name="direct_reports"
                                    @reset="form.clearErrors('direct_reports')"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end bg-gray-50 py-3 px-4 text-right sm:rounded-b-md sm:px-6">
                    <IndigoButton
                        :disabled="form.processing"
                    >
                        Save
                    </IndigoButton>
                </div>
            </div>
        </form>
    </div>
</template>