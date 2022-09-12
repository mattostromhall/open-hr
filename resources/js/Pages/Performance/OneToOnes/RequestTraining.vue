<script setup lang="ts">
import {useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import TextAreaInput from '@/Components/Controls/TextAreaInput.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import usePerson from '../../../Hooks/usePerson'
import type {Training} from '../../../types'

type TrainingRequestData = Omit<Training, 'id' | 'status' | 'progress'>

const emit = defineEmits(['setActive'])

const person = usePerson()

const form: InertiaForm<TrainingRequestData> = useForm({
    person_id: person.value.id,
    description: '',
    provider: '',
    location: undefined,
    cost: undefined,
    duration: undefined,
    notes: undefined
})

function submit(): void {
    form.post('/training', {
        onSuccess: () => {
            emit('setActive', 'training')
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
                            Request Training
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Submit a request to your manager.
                        </p>
                    </div>
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <FormLabel>Description <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <TextInput
                                    v-model="form.description"
                                    :error="form.errors.description"
                                    :time-enabled="true"
                                    input-id="description"
                                    input-name="description"
                                    @reset="form.clearErrors('description')"
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