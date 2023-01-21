<script setup lang="ts">
import {useForm} from '@inertiajs/vue3'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import DateInput from '@/Components/Controls/DateInput.vue'
import NumberInput from '@/Components/Controls/NumberInput.vue'
import TextAreaInput from '@/Components/Controls/TextAreaInput.vue'
import SelectInput from '@/Components/Controls/SelectInput.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import FileInput from '@/Components/Controls/FileInput.vue'
import FilePreview from '@/Components/FilePreview.vue'
import usePerson from '../../Hooks/usePerson'
import type {Expense, SelectOption} from '../../types'
import {computed} from 'vue'
import type {ComputedRef} from 'vue'
import currencies from '../../Shared/currencies'

defineProps<{
    expenseTypes: SelectOption[]
}>()

type SubmitExpenseData = Omit<Expense, 'id' | 'expense_type_id'>
    &
    {
        expense_type_id?: number
        documents: File | File[] | undefined
    }

const emit = defineEmits(['setActive'])

const person = usePerson()

const form = useForm<SubmitExpenseData>({
    person_id: person.value.id,
    expense_type_id: undefined,
    status: 1,
    value: 0,
    value_currency: 'GBP',
    date: '',
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
    form.post('/expenses', {
        onSuccess: () => {
            emit('setActive', 'pending')
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
                            Submit an Expense
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Submit an Expense to your manager.
                        </p>
                    </div>
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <FormLabel>Type</FormLabel>
                            <div class="mt-1">
                                <SelectInput
                                    v-model="form.expense_type_id"
                                    :error="form.errors.expense_type_id"
                                    :options="expenseTypes"
                                    input-id="expense_type"
                                    input-name="expense_type"
                                    placeholder="Select an Expense Type..."
                                    @reset="form.clearErrors('expense_type_id')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Value</FormLabel>
                            <div class="mt-1">
                                <NumberInput
                                    v-model.number="form.value"
                                    :error="form.errors.value"
                                    input-id="value"
                                    input-name="value"
                                    :step="0.01"
                                    @reset="form.clearErrors('value')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Currency</FormLabel>
                            <div class="mt-1">
                                <SelectInput
                                    v-model="form.value_currency"
                                    :error="form.errors.value_currency"
                                    :options="currencies"
                                    input-id="value_currency"
                                    input-name="value_currency"
                                    placeholder="Select a Currency..."
                                    @reset="form.clearErrors('value_currency')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-5">
                            <FormLabel>Date <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <DateInput
                                    v-model="form.date"
                                    :error="form.errors.date"
                                    input-id="date"
                                    input-name="date"
                                    @reset="form.clearErrors('date')"
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