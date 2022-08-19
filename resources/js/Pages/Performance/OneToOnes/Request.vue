<script setup lang="ts">
import {useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import DateInput from '@/Components/Controls/DateInput.vue'
import TextAreaInput from '@/Components/Controls/TextAreaInput.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import usePerson from '../../../Hooks/usePerson'
import type {OneToOne} from '../../../types'
import type {Person} from '../../../types'

const props = defineProps<{
    manager: Pick<Person, 'id'|'full_name'>,
}>()

type OneToOneRequestData = Omit<OneToOne, 'id' | 'status' | 'completed_at'>

const emit = defineEmits(['setActive'])

const person = usePerson()

const form: InertiaForm<OneToOneRequestData> = useForm({
    person_id: person.value.id,
    manager_id: props.manager.id,
    requester_id: person.value.id,
    person_status: 2,
    manager_status: 1,
    scheduled_at: '',
    recurring: false,
    recurrence_interval: 'never',
    notes: ''
})

function submit(): void {
    form.post('/one-to-ones', {
        onSuccess: () => {
            emit('setActive', 'upcoming')
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
                            Request a One-to-one
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Submit a request to your manager.
                        </p>
                    </div>
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <FormLabel>Suggest a date and time <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <DateInput
                                    v-model="form.scheduled_at"
                                    :error="form.errors.scheduled_at"
                                    :time-enabled="true"
                                    input-id="scheduled_at"
                                    input-name="scheduled_at"
                                    @reset="form.clearErrors('scheduled_at')"
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