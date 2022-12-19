<script setup lang="ts">
import DateInput from '@/Components/Controls/DateInput.vue'
import NumberInput from '@/Components/Controls/NumberInput.vue'
import SearchableSelectInput from '@/Components/Controls/SearchableSelectInput.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import TextAreaInput from '@/Components/Controls/TextAreaInput.vue'
import OperatorInput from '@/Components/Controls/OperatorInput.vue'
import type {ReportableColumn, ReportCondition, SelectOption} from '../../types'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import type {Component, ComputedRef} from 'vue'
import {computed} from 'vue'

const props = defineProps<{
    condition: ReportCondition,
    reportableColumns: ReportableColumn[],
    columnError?: string,
    operatorError?: string,
    valueError?: string
}>()

const emit = defineEmits([
    'update:column',
    'update:operator',
    'update:value'
])

const columns: ComputedRef<SelectOption[]> = computed(() => props.reportableColumns.map((reportableColumn: ReportableColumn) => {
    return {
        value: reportableColumn.column,
        display: reportableColumn.display
    }
}))

const inputMap: {[key: string]: Component} = {
    'Date': DateInput,
    'Number': NumberInput,
    'TextArea': TextAreaInput,
    'Text': TextInput
}

const selected: ComputedRef<ReportableColumn | undefined> = computed(() => props.reportableColumns.find(
    reportableColumn => reportableColumn.column === props.condition.column)
)

const inputFromType: ComputedRef<Component | string> = computed(() => {
    if (selected.value) {
        return inputMap[selected.value.type] ?? TextInput
    }

    return TextInput
})
</script>

<template>
    <div class="flex mr-3 mb-3 space-x-6">
        <div class="text-center">
            <FormLabel class="block mb-1 text-xs">
                Column
            </FormLabel>
            <SearchableSelectInput
                class="w-48 text-xs"
                :options="columns"
                placeholder-value="Choose column..."
                :model-value="condition.column"
                :error="columnError"
                @update:model-value="emit('update:column', $event)"
            />
        </div>
        <div class="text-center">
            <FormLabel class="block mb-1 text-xs">
                Operator
            </FormLabel>
            <OperatorInput
                class="w-48 text-xs"
                :options="[]"
                placeholder-value="Choose operator..."
                :model-value="condition.operator"
                @update:model-value="emit('update:operator', $event)"
            />
        </div>
        <div class="text-center">
            <FormLabel class="block mb-1 text-xs">
                Value
            </FormLabel>
            <Component
                :is="inputFromType"
                class="w-52"
                :model-value="condition.value"
                @update:model-value="$emit('update:value', $event)"
            />
        </div>
    </div>
</template>
