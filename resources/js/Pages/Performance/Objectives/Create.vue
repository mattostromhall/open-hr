<script setup lang="ts">
import EditorInput from '@/Components/Controls/EditorInput.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import SearchableSelectInput from '@/Components/Controls/SearchableSelectInput.vue'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import DateInput from '@/Components/Controls/DateInput.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import {useForm} from '@inertiajs/inertia-vue3'
import type {Objective} from '../../../types'
import type {Person} from '../../../types'
import {computed} from 'vue'
import type {ComputedRef} from 'vue'

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

type ObjectiveData = Omit<Objective, 'id' | 'person_id' | 'completed_at'> & {person_id?: number}

const form: InertiaForm<ObjectiveData> = useForm({
    person_id: undefined,
    title: '',
    description: '',
    due_at: ''
})

function submit(): void {
    form.post('/objectives', {
        onSuccess: () => {
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
                            Add an Objective
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Add an objective for one of your direct reports.
                        </p>
                    </div>
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>For <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <SearchableSelectInput
                                    v-model="form.person_id"
                                    :options="directReportOptions"
                                    :error="form.errors.person_id"
                                    @reset="form.clearErrors('person_id')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
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
                        <div class="col-span-6">
                            <FormLabel>Description <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <EditorInput v-model="form.description" />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Set a due date <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <DateInput
                                    v-model="form.due_at"
                                    :error="form.errors.due_at"
                                    input-id="due_at"
                                    input-name="due_at"
                                    @reset="form.clearErrors('due_at')"
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