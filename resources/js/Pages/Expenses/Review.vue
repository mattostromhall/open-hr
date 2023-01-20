<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import {Head, useForm} from '@inertiajs/vue3'
import type {InertiaForm} from '@inertiajs/vue3'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import TextAreaInput from '@/Components/Controls/TextAreaInput.vue'
import SelectInput from '@/Components/Controls/SelectInput.vue'
import type {ExpenseStatus, Expense, SelectOption, DocumentListItem} from '../../types'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import DocumentList from '../Files/Documents/DocumentList.vue'

const props = defineProps<{
    expense: Expense,
    requester: string,
    status: string,
    expenseTypes: SelectOption[],
    documents: DocumentListItem[]
}>()

interface ReviewExpenseData {
    expense_type_id: number,
    status: ExpenseStatus,
    notes?: string
}

const form: InertiaForm<ReviewExpenseData> = useForm({
    expense_type_id: props.expense.expense_type_id,
    status: props.expense.status,
    notes: props.expense.notes ?? undefined
})

function submit(): void {
    form.patch(`/expenses/${props.expense.id}/review`)
}

function approve(): void {
    form.status = 2

    submit()
}

function reject(): void {
    form.status = 3

    submit()
}
</script>

<template>
    <Head>
        <title>Review Submitted Expense</title>
    </Head>

    <section class="p-8">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="py-5 px-4 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Expense submitted by {{ requester }}
                </h3>
                <div class="mt-2 max-w-xl text-sm text-gray-500">
                    <p>
                        Date - {{ useDateFormat(expense.date, 'DD/MM/YYYY').value }}
                    </p>
                    <p>
                        Value - {{ expense.value }} {{ expense.value_currency }}
                    </p>
                    <p class="mt-1">
                        Status: {{ status }}
                    </p>
                    <p
                        v-if="expense.notes"
                        class="mt-1"
                    >
                        Expense info: {{ expense.notes }}
                    </p>
                </div>
                <div class="mt-3 max-w-xs">
                    <FormLabel>Type <RequiredIcon /></FormLabel>
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
                <div class="mt-3">
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
                <div class="mt-5 flex space-x-5">
                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-green-100 py-2 px-4 font-medium text-green-700 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:text-sm"
                        @click="approve"
                    >
                        Approve
                    </button>
                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-100 py-2 px-4 font-medium text-red-700 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:text-sm"
                        @click="reject"
                    >
                        Reject
                    </button>
                </div>
            </div>
        </div>
        <DocumentList
            class="mt-6"
            :items="documents"
        />
    </section>
</template>