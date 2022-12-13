<script setup lang="ts">
import DateInput from '@/Components/Controls/DateInput.vue'
import NumberInput from '@/Components/Controls/NumberInput.vue'
import SearchableSelectInput from '@/Components/Controls/SearchableSelectInput.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import OperatorInput from '@/Components/Controls/OperatorInput.vue'
import type {ReportableColumn, ReportCondition, SelectOption} from '../../types'
import FormLabel from '../../Components/Controls/FormLabel.vue'
import type {ComputedRef} from 'vue'
import {computed} from 'vue'

const props = defineProps<{
    condition: ReportCondition,
    reportableColumns: ReportableColumn[]
}>()

const emit = defineEmits([
    'update:column',
    'update:operator',
    'update:value'
])

const columns: ComputedRef<SelectOption[]> = computed(() => props.reportableColumns.map((column: ReportableColumn) => {
    return {
        value: column.column,
        display: column.display
    }
}))

const getInputFromType: ComputedRef<string> = computed(() => {
    if (props.condition.column) {
        //
    }

    return 'TextInput'
})
</script>

<template>
    <div class="flex mr-3 mb-3 space-x-6">
        <div class="text-center">
            <FormLabel class="block mb-1 text-xs">
                Column
            </FormLabel>
            <SearchableSelectInput
                class="w-44 text-xs"
                :options="columns"
                placeholder-value="Choose column..."
                :model-value="condition.column"
                @update:model-value="emit('update:column', $event)"
            />
        </div>
        <div class="text-center">
            <FormLabel class="block mb-1 text-xs">
                Operator
            </FormLabel>
            <OperatorInput
                class="w-44 text-xs"
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
                :is="getInputFromType"
                class="w-44"
                :model-value="condition.value"
                @update:model-value="$emit('update:value', $event)"
            />
        </div>
    </div>
</template>
