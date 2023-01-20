<script setup lang="ts">
import {useForm} from '@inertiajs/vue3'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import DateInput from '@/Components/Controls/DateInput.vue'
import TextAreaInput from '@/Components/Controls/TextAreaInput.vue'
import FileInput from '@/Components/Controls/FileInput.vue'
import FilePreview from '@/Components/FilePreview.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import usePerson from '../../../Hooks/usePerson'
import type {Sickness} from '../../../types'
import {computed} from 'vue'
import type {ComputedRef} from 'vue'

type LogSicknessData = Omit<Sickness, 'id'> & {documents?: File | File[]}

const emit = defineEmits(['setActive'])

const person = usePerson()

const form: LogSicknessData = useForm({
    person_id: person.value.id,
    start_at: '',
    finish_at: undefined,
    notes: undefined,
    documents: undefined
})

const documentError: ComputedRef<string> = computed(() => {
    let message = ''

    Object.entries(form.errors).find(([key, value]) => {
        if (key.startsWith('documents')) {
            message = value
            return true
        }

        return false
    })

    return message
})

function submit(): void {
    form.post('/sicknesses', {
        onSuccess: () => {
            emit('setActive', 'sicknesses')
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
                            Log a Sick Day/Days
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Log a Sick Day/Days and provide any information as required.
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
                            <FormLabel>Finish at</FormLabel>
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
                        <div class="col-span-6">
                            <FormLabel>Documents</FormLabel>
                            <div class="mt-1">
                                <FileInput
                                    :error="documentError"
                                    input-id="documents"
                                    input-name="documents"
                                    :multiple="true"
                                    @update:model-value="form.documents = $event"
                                    @reset="form.clearErrors()"
                                />
                                <FilePreview
                                    v-for="(document, index) in form.documents"
                                    :key="index"
                                    class="mt-5"
                                    :file="document"
                                    :name="document?.name"
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