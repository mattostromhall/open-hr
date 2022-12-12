<!--<script>-->
<!--import {mapFieldComponent, mapOperators} from '@/shared/mapFieldType'-->
<!--import BlueButton from '@/Components/Buttons/BlueButton'-->
<!--import CurrencyInput from '@/Components/Forms/CurrencyInput'-->
<!--import DateInput from '@/Components/Forms/DynamicDateInput'-->
<!--import DatetimeInput from '@/Components/Forms/DynamicDateTimeInput'-->
<!--import EmailInput from '@/Components/Forms/EmailInput'-->
<!--import LoadingIndicator from '@/Components/Utilities/LoadingIndicator'-->
<!--import LookupInput from '@/Components/Forms/LookupInput'-->
<!--import MergeTagTextInput from '@/Components/Forms/MergeTagTextInput'-->
<!--import MultiSelectDropdown from '@/Components/Forms/MultiSelectDropdown'-->
<!--import MultiSelectLookupInput from '@/Components/Forms/MultiSelectLookupInput'-->
<!--import NumberInput from '@/Components/Forms/NumberInput'-->
<!--import PercentInput from '@/Components/Forms/PercentInput'-->
<!--import SearchableSelectDropdown from '@/Components/Forms/SearchableSelectDropdown'-->
<!--import SelectDropdown from '@/Components/Forms/SelectDropdown'-->
<!--import TextInput from '@/Components/Forms/TextInput'-->
<!--import TextareaInput from '@/Components/Forms/TextareaInput'-->
<!--import ToggleInput from '@/Components/Forms/ToggleInput'-->
<!--import { mapState } from 'vuex'-->

<!--export default {-->
<!--    components: {-->
<!--        BlueButton,-->
<!--        CurrencyInput,-->
<!--        DateInput,-->
<!--        DatetimeInput,-->
<!--        EmailInput,-->
<!--        LoadingIndicator,-->
<!--        LookupInput,-->
<!--        MergeTagTextInput,-->
<!--        MultiSelectDropdown,-->
<!--        MultiSelectLookupInput,-->
<!--        NumberInput,-->
<!--        PercentInput,-->
<!--        SearchableSelectDropdown,-->
<!--        SelectDropdown,-->
<!--        TextInput,-->
<!--        TextareaInput,-->
<!--        ToggleInput-->
<!--    },-->
<!--    inject: ['operators'],-->
<!--    props: {-->
<!--        condition: {-->
<!--            type: Object,-->
<!--            required: true-->
<!--        },-->
<!--        models: {-->
<!--            type: Array-->
<!--        },-->
<!--        objectFields: {-->
<!--            type: Object-->
<!--        },-->
<!--        setField: {-->
<!--            type: Function,-->
<!--            required: true-->
<!--        },-->
<!--        object: {-->
<!--            type: String-->
<!--        },-->
<!--        operator: {-->
<!--            type: String-->
<!--        },-->
<!--        value: {}-->
<!--    },-->
<!--    emits: [-->
<!--        'update:object',-->
<!--        'update:operator',-->
<!--        'update:value',-->
<!--        'update:displayValue'-->
<!--    ],-->
<!--    data() {-->
<!--        return {-->
<!--            lookupFieldTypes: ['lookup', 'lookup.csv', 'lookup.sql', 'lookup.table', 'sqllookup']-->
<!--        }-->
<!--    },-->
<!--    computed: {-->
<!--        showValueInput() {-->
<!--            return this.condition.object-->
<!--                && this.condition.field.name-->
<!--                && this.condition.operator !== 'not set'-->
<!--        },-->
<!--        multiSelectValue() {-->
<!--            if (!this.value) {-->
<!--                return []-->
<!--            }-->

<!--            if (this.value.includes(',')) {-->
<!--                return this.value.split(',')-->
<!--            }-->

<!--            return [this.value]-->
<!--        },-->
<!--        campaignNames() {-->
<!--            return this.campaigns.map(campaign => campaign.Name)-->
<!--        },-->
<!--        campaignStageNames() {-->
<!--            return this.campaigns-->
<!--                .flatMap(campaign => campaign.stages)-->
<!--                .map(stage => stage.Name)-->
<!--        },-->
<!--        ...mapState({-->
<!--            campaigns: state => state.automations.campaigns-->
<!--        })-->
<!--    },-->
<!--    methods: {-->
<!--        isLookupField(field) {-->
<!--            return this.lookupFieldTypes.includes(field.type) || field.hasLookupTable-->
<!--        },-->
<!--        isMultiSelectLookupField(field) {-->
<!--            return this.isLookupField(field)-->
<!--                && (this.operator === 'is one of' || this.operator === '!is one of')-->
<!--        },-->
<!--        isCampaign(field) {-->
<!--            return field.description === 'Campaign Name'-->
<!--        },-->
<!--        isCampaignStage(field) {-->
<!--            return field.description === 'Campaign Stage Name'-->
<!--        },-->
<!--        mapFieldType(type) {-->
<!--            return mapFieldComponent(type)-->
<!--        },-->
<!--        mapOperators(field) {-->
<!--            const allowedOperators = mapOperators(field.type)-->

<!--            if (this.isLookupField(field)) {-->
<!--                allowedOperators.push('is one of', '!is one of')-->
<!--            }-->

<!--            return allowedOperators-->
<!--                ? this.operators.filter(operator => allowedOperators.includes(operator.value))-->
<!--                : []-->
<!--        },-->
<!--        emitLookup(e) {-->
<!--            this.$emit('update:value', e.value)-->
<!--            this.$emit('update:displayValue', e.displayValue)-->
<!--        },-->
<!--        emitMultiSelectLookup(e) {-->
<!--            this.$emit('update:value', e.value.join(','))-->
<!--            this.$emit('update:displayValue', e.displayValue.join(', '))-->
<!--        }-->
<!--    }-->
<!--}-->
<!--</script>-->

<!--<template>-->
<!--    <div class="flex mr-3 mb-3 space-x-6">-->
<!--        <div class="text-center">-->
<!--            <label class="block mb-1 text-xs">{{ __('Object') }}</label>-->
<!--            <SelectDropdown-->
<!--                class="w-42 text-xs"-->
<!--                :options="objects"-->
<!--                value-key="Name"-->
<!--                display-key="ObjectName"-->
<!--                :placeholder-value="__('Choose object') + '...'"-->
<!--                :model-value="object"-->
<!--                @update:model-value="$emit('update:object', $event)"-->
<!--            />-->
<!--        </div>-->
<!--        <div-->
<!--            v-show="condition.object"-->
<!--            class="text-center"-->
<!--        >-->
<!--            <label class="block mb-1 text-xs">{{ __('Field') }}</label>-->
<!--            <SelectDropdown-->
<!--                class="w-42 text-xs"-->
<!--                value-key="FieldName"-->
<!--                display-key="FieldDescription"-->
<!--                :options="objectFields"-->
<!--                :placeholder-value="__('Choose field') + '...'"-->
<!--                :model-value="condition.field.name"-->
<!--                @update:model-value="setField($event, condition)"-->
<!--            />-->
<!--        </div>-->
<!--        <div-->
<!--            v-show="condition.object && condition.field.name"-->
<!--            class="text-center"-->
<!--        >-->
<!--            <label class="block mb-1 text-xs">{{ __('Operator') }}</label>-->
<!--            <SelectDropdown-->
<!--                class="w-42 text-xs"-->
<!--                :options="mapOperators(condition.field)"-->
<!--                value-key="value"-->
<!--                display-key="display"-->
<!--                :placeholder-value="__('Choose operator') + '...'"-->
<!--                :model-value="operator"-->
<!--                @update:model-value="$emit('update:operator', $event)"-->
<!--            />-->
<!--        </div>-->
<!--        <div-->
<!--            v-show="showValueInput"-->
<!--            class="text-center"-->
<!--        >-->
<!--            <label class="block mb-1 text-xs">{{ __('Value') }}</label>-->
<!--            <MultiSelectLookupInput-->
<!--                v-if="isMultiSelectLookupField(condition.field)"-->
<!--                class="w-52"-->
<!--                :field-name="condition.field.name"-->
<!--                :object-name="object"-->
<!--                :model-value="multiSelectValue"-->
<!--                @update:model-value="emitMultiSelectLookup"-->
<!--            />-->
<!--            <LookupInput-->
<!--                v-else-if="isLookupField(condition.field)"-->
<!--                class="w-42"-->
<!--                :field-name="condition.field.name"-->
<!--                :object-name="condition.object"-->
<!--                :model-value="value"-->
<!--                @update:model-value="emitLookup"-->
<!--            />-->
<!--            <SearchableSelectDropdown-->
<!--                v-else-if="isCampaign(condition.field)"-->
<!--                id="campaigns"-->
<!--                class="w-60"-->
<!--                :options="campaignNames"-->
<!--                :placeholder-value="__('Choose campaign') + '...'"-->
<!--                :model-value="value"-->
<!--                @update:model-value="$emit('update:value', $event)"-->
<!--            />-->
<!--            <SearchableSelectDropdown-->
<!--                v-else-if="isCampaignStage(condition.field)"-->
<!--                id="campaign-stages"-->
<!--                class="w-60"-->
<!--                :options="campaignStageNames"-->
<!--                :placeholder-value="__('Choose campaign stage') + '...'"-->
<!--                :model-value="value"-->
<!--                @update:model-value="$emit('update:value', $event)"-->
<!--            />-->
<!--            <Component-->
<!--                :is="mapFieldType(condition.field.type)"-->
<!--                v-else-->
<!--                :class="{'w-42': condition.field.type !== 'checkbox'}"-->
<!--                :model-value="value"-->
<!--                @update:model-value="$emit('update:value', $event)"-->
<!--            />-->
<!--        </div>-->
<!--    </div>-->
<!--</template>-->
