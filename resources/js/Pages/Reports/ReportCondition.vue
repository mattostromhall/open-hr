<script setup lang="ts">
import DateInput from '@/Components/Controls/DateInput.vue'
import NumberInput from '@/Components/Controls/NumberInput.vue'
import SearchableSelectInput from '@/Components/Controls/SearchableSelectInput.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import SelectInput from '@/Components/Controls/SelectInput.vue'
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

// export default {
//     props: {
//         condition: {
//             type: Object,
//             required: true
//         },
//         models: {
//             type: Array
//         },
//         objectFields: {
//             type: Object
//         },
//         setField: {
//             type: Function,
//             required: true
//         },
//         object: {
//             type: String
//         },
//         operator: {
//             type: String
//         },
//         value: {}
//     },
//     emits: [
//         'update:column',
//         'update:operator',
//         'update:value'
//     ],
//     computed: {
//         showValueInput() {
//             return this.condition.object
//                 && this.condition.field.name
//                 && this.condition.operator !== 'not set'
//         },
//         multiSelectValue() {
//             if (!this.value) {
//                 return []
//             }
//
//             if (this.value.includes(',')) {
//                 return this.value.split(',')
//             }
//
//             return [this.value]
//         }
//     },
//     methods: {
//         mapFieldType(type) {
//             return mapFieldComponent(type)
//         },
//         mapOperators(field) {
//             const allowedOperators = mapOperators(field.type)
//
//             if (this.isLookupField(field)) {
//                 allowedOperators.push('is one of', '!is one of')
//             }
//
//             return allowedOperators
//                 ? this.operators.filter(operator => allowedOperators.includes(operator.value))
//                 : []
//         }
//     }
// }
</script>

<template>
    <div class="flex mr-3 mb-3 space-x-6">
        <div class="text-center">
            <FormLabel class="block mb-1 text-xs">
                Column
            </FormLabel>
            <SearchableSelectInput
                class="w-42 text-xs"
                :options="columns"
                placeholder-value="Choose column..."
                :model-value="condition.column"
                @update:model-value="emit('update:object', $event)"
            />
        </div>
        <div class="text-center">
            <FormLabel class="block mb-1 text-xs">
                Operator
            </FormLabel>
            <SelectInput
                class="w-42 text-xs"
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
            <!--            <Component-->
            <!--                :is="mapFieldType(condition.field.type)"-->
            <!--                v-else-->
            <!--                :class="{'w-42': condition.field.type !== 'checkbox'}"-->
            <!--                :model-value="value"-->
            <!--                @update:model-value="$emit('update:value', $event)"-->
            <!--            />-->
        </div>
    </div>
</template>
