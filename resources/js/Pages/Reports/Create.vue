<script setup lang="ts">
import ReportCondition from './ReportCondition.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import type {ReportableColumn, SelectOption} from '../../types'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import SearchableSelectInput from '../../Components/Controls/SearchableSelectInput.vue'

const props = defineProps<{
    models: string[],
    reportableColumns: {
        [model: string]: ReportableColumn[]
    }
}>()

</script>

<template>
    <Head>
        <title>Reporting</title>
    </Head>

    <PageHeading>
        Create Report
        <template #link>
            <LightIndigoLink href="/organisation/dashboard">
                Dashboard
            </LightIndigoLink>
        </template>
    </PageHeading>

    <section class="p-8">
        <SearchableSelectInput :options="models" />
    </section>
</template>
<!--export default {-->
<!--    components: {-->
<!--        ReportCondition,-->
<!--        IndigoButton-->
<!--    },-->
<!--    data() {-->
<!--        return {-->
<!--            modalsOpen: [false],-->
<!--            conditionSets: [-->
<!--                [-->
<!--                    {-->
<!--                        model: '',-->
<!--                        condition: {-->
<!--                            column: '',-->
<!--                            operator: '',-->
<!--                            value: ''-->
<!--                        }-->
<!--                    }-->
<!--                ]-->
<!--            ]-->
<!--        }-->
<!--    },-->
<!--    computed: {-->
<!--        objectNames() {-->
<!--            return this.objects.map(object => object.Name)-->
<!--        },-->
<!--        fields() {-->
<!--            return this.fieldsForObjects(this.objectNames, 'readable')-->
<!--        },-->
<!--        lastConditionSet() {-->
<!--            return this.filter.conditionSets[this.filter.conditionSets.length - 1]-->
<!--        },-->
<!--        conditionSetButtonDisabled() {-->
<!--            return this.conditionButtonDisabled(this.lastConditionSet)-->
<!--        },-->
<!--        addButtonDisabled() {-->
<!--            return this.conditionSetButtonDisabled-->
<!--        }-->
<!--    },-->
<!--    methods: {-->
<!--        openModal(index) {-->
<!--            this.modalsOpen.splice(index, 1, true)-->
<!--        },-->
<!--        closeModal(index) {-->
<!--            this.modalsOpen.splice(index, 1, false)-->
<!--        },-->
<!--        lastConditionInSet(set) {-->
<!--            return set[set.length - 1]-->
<!--        },-->
<!--        conditionButtonDisabled(conditionSet) {-->
<!--            const condition = this.lastConditionInSet(conditionSet)-->
<!--            return condition.object === '' || condition.field.name === '' || condition.operator === ''-->
<!--        },-->
<!--        addConditionSet() {-->
<!--            this.filter.conditionSets.push([-->
<!--                [-->
<!--                    {-->
<!--                        model: '',-->
<!--                        condition: {-->
<!--                            column: '',-->
<!--                            operator: '',-->
<!--                            value: ''-->
<!--                        }-->
<!--                    }-->
<!--                ]-->
<!--            ])-->
<!--            this.modalsOpen.push(false)-->
<!--        },-->
<!--        removeConditionSet(index) {-->
<!--            this.filter.conditionSets.splice(index, 1)-->
<!--            this.modalsOpen.splice(index, 1)-->
<!--        },-->
<!--        addCondition(index) {-->
<!--            this.filter.conditionSets[index].push({-->
<!--                object: '',-->
<!--                field: {-->
<!--                    type: '',-->
<!--                    name: '',-->
<!--                    description: '',-->
<!--                    shortDescription: '',-->
<!--                    hasLookupTable: false-->
<!--                },-->
<!--                operator: '',-->
<!--                value: null,-->
<!--                displayValue: null-->
<!--            })-->
<!--        },-->
<!--        removeCondition(conditionSet, index) {-->
<!--            conditionSet.splice(index, 1)-->
<!--        },-->
<!--        objectFields(object) {-->
<!--            return this.fields[object]-->
<!--        },-->
<!--        setField(value, condition) {-->
<!--            const field = this.fields[condition.object].find(-->
<!--                field => field.FieldName === value-->
<!--            )-->
<!--            condition.field = {-->
<!--                type: field.FieldType,-->
<!--                name: field.FieldName,-->
<!--                description: field.FieldDescription,-->
<!--                shortDescription: field.FieldShortDescription,-->
<!--                hasLookupTable: !!field.LookupTable-->
<!--            }-->
<!--            condition.value = null-->
<!--            condition.displayValue = null-->
<!--        },-->
<!--        resetCondition(condition) {-->
<!--            condition.field = {-->
<!--                type: '',-->
<!--                name: '',-->
<!--                description: '',-->
<!--                shortDescription: '',-->
<!--                hasLookupTable: false-->
<!--            }-->
<!--            condition.operator = ''-->
<!--            condition.value = null-->
<!--            condition.displayValue = null-->
<!--        }-->
<!--    }-->
<!--}-->
<!--</script>-->

<!--<template>-->
<!--    <div class="mt-6 space-y-6">-->
<!--        <div-->
<!--            v-for="(conditionSet, index) in conditionSets"-->
<!--            :key="conditionSet"-->
<!--            class="relative p-3 pt-8 rounded border"-->
<!--        >-->
<!--            <template v-if="index === 0">-->
<!--                <div-->
<!--                    v-for="(condition, conditionIndex) in conditionSet"-->
<!--                    :key="condition"-->
<!--                    class="flex items-end"-->
<!--                >-->
<!--                    <ReportCondition-->
<!--                        v-model:object="condition.model"-->
<!--                        v-model:operator="condition.operator"-->
<!--                        v-model:value="condition.value"-->
<!--                        :condition="condition"-->
<!--                        :models="models"-->
<!--                        @update:object="resetCondition(condition)"-->
<!--                    />-->
<!--                    <button-->
<!--                        v-if="conditionSet.length > 1"-->
<!--                        class="flex shrink-0 justify-center items-center mb-3 w-8 h-7 text-red-50 bg-red-700 hover:bg-red-600 rounded focus:outline-none focus:ring focus:ring-red-300 hover:shadow-lg transition duration-300 ease-in-out"-->
<!--                        @click="removeCondition(conditionSet, index)"-->
<!--                    >-->
<!--                        <i class="fas fa-trash-alt text-xs" />-->
<!--                    </button>-->
<!--                </div>-->
<!--                <button-->
<!--                    v-if="conditionSets.length > 1"-->
<!--                    class="flex absolute top-0 right-0 justify-center items-center -mt-3 -mr-3 mb-3 w-7 h-6 text-red-50 bg-red-700 hover:bg-red-600 rounded focus:outline-none focus:ring focus:ring-red-300 hover:shadow-lg transition duration-300 ease-in-out"-->
<!--                    @click="openModal(index)"-->
<!--                >-->
<!--                    <i class="text-2xs fas fa-trash-alt" />-->
<!--                    &lt;!&ndash;                    <ConfirmationModal&ndash;&gt;-->
<!--                    &lt;!&ndash;                        v-if="modalsOpen[index]"&ndash;&gt;-->
<!--                    &lt;!&ndash;                        :model-value="modalsOpen[index]"&ndash;&gt;-->
<!--                    &lt;!&ndash;                        :on-confirm="() => removeConditionSet(index)"&ndash;&gt;-->
<!--                    &lt;!&ndash;                        confirmation-button="RedButton"&ndash;&gt;-->
<!--                    &lt;!&ndash;                        modal-id="removeConditionSetModal"&ndash;&gt;-->
<!--                    &lt;!&ndash;                        confirmation-button-dusk-selector="removeConditionSet"&ndash;&gt;-->
<!--                    &lt;!&ndash;                        @update:model0-value="closeModal(index)"&ndash;&gt;-->
<!--                    &lt;!&ndash;                    >&ndash;&gt;-->
<!--                    &lt;!&ndash;                        <template #header>&ndash;&gt;-->
<!--                    &lt;!&ndash;                            {{ __('Remove condition set') }}&ndash;&gt;-->
<!--                    &lt;!&ndash;                        </template>&ndash;&gt;-->
<!--                    &lt;!&ndash;                        <div class="w-60 text-center">&ndash;&gt;-->
<!--                    &lt;!&ndash;                            <p>Are you sure?</p>&ndash;&gt;-->
<!--                    &lt;!&ndash;                        </div>&ndash;&gt;-->
<!--                    &lt;!&ndash;                        <template #close-button>&ndash;&gt;-->
<!--                    &lt;!&ndash;                            {{ __('Cancel') }}&ndash;&gt;-->
<!--                    &lt;!&ndash;                        </template>&ndash;&gt;-->
<!--                    &lt;!&ndash;                        <template #confirm-button>&ndash;&gt;-->
<!--                    &lt;!&ndash;                            {{ __('Remove') }}&ndash;&gt;-->
<!--                    &lt;!&ndash;                        </template>&ndash;&gt;-->
<!--                    &lt;!&ndash;                    </ConfirmationModal>&ndash;&gt;-->
<!--                </button>-->
<!--                <IndigoButton-->
<!--                    button-classes="flex items-center mt-3"-->
<!--                    :disabled="conditionButtonDisabled(conditionSet)"-->
<!--                    @click="addCondition(index)"-->
<!--                >-->
<!--                    <i class="fas fa-plus mr-2 text-base leading-5" />-->
<!--                    <span class="text-xs">{{ __('And') }}</span>-->
<!--                </IndigoButton>-->
<!--            </template>-->
<!--            <template v-else>-->
<!--                <div class="bg-rss-blue-200 focus:ring-rss-blue-300 absolute top-0 left-0 py-1 px-2 -mt-3 ml-2 text-xs rounded focus:outline-none focus:ring select-none">-->
<!--                    {{ __('Or') }}-->
<!--                </div>-->
<!--                <button-->
<!--                    class="flex absolute top-0 right-0 justify-center items-center -mt-3 -mr-3 mb-3 w-7 h-6 text-red-50 bg-red-700 hover:bg-red-600 rounded focus:outline-none focus:ring focus:ring-red-300 hover:shadow-lg transition duration-300 ease-in-out"-->
<!--                    @click="openModal(index)"-->
<!--                >-->
<!--                    <i class="text-2xs fas fa-trash-alt" />-->
<!--                    <ConfirmationModal-->
<!--                        v-if="modalsOpen[index]"-->
<!--                        :model-value="modalsOpen[index]"-->
<!--                        :on-confirm="() => removeConditionSet(index)"-->
<!--                        confirmation-button="RedButton"-->
<!--                        modal-id="removeConditionSetModal"-->
<!--                        confirmation-button-dusk-selector="removeConditionSet"-->
<!--                        @update:modelValue="closeModal(index)"-->
<!--                    >-->
<!--                        <template #header>-->
<!--                            {{ __('Remove condition set') }}-->
<!--                        </template>-->
<!--                        <div class="w-60 text-center">-->
<!--                            <p>Are you sure?</p>-->
<!--                        </div>-->
<!--                        <template #close-button>-->
<!--                            {{ __('Cancel') }}-->
<!--                        </template>-->
<!--                        <template #confirm-button>-->
<!--                            {{ __('Remove') }}-->
<!--                        </template>-->
<!--                    </ConfirmationModal>-->
<!--                </button>-->
<!--                <div class="relative p-3 pt-8 rounded border">-->
<!--                    <div-->
<!--                        v-for="(condition, index) in conditionSet"-->
<!--                        :key="condition"-->
<!--                        class="flex items-end"-->
<!--                    >-->
<!--                        <FilterCondition-->
<!--                            v-model:object="condition.object"-->
<!--                            v-model:operator="condition.operator"-->
<!--                            v-model:value="condition.value"-->
<!--                            v-model:displayValue="condition.displayValue"-->
<!--                            :condition="condition"-->
<!--                            :objects="objects"-->
<!--                            :object-fields="objectFields(condition.object)"-->
<!--                            :set-field="setField"-->
<!--                            @update:object="resetCondition(condition)"-->
<!--                        />-->
<!--                        <button-->
<!--                            v-if="conditionSet.length > 1"-->
<!--                            class="flex shrink-0 justify-center items-center mb-3 w-8 h-7 text-red-50 bg-red-700 hover:bg-red-600 rounded focus:outline-none focus:ring focus:ring-red-300 hover:shadow-lg transition duration-300 ease-in-out"-->
<!--                            @click="removeCondition(conditionSet, index)"-->
<!--                        >-->
<!--                            <i class="fas fa-trash-alt text-xs" />-->
<!--                        </button>-->
<!--                    </div>-->
<!--                    <div-->
<!--                        v-show="conditionSet.length > 1"-->
<!--                        class="bg-rss-blue-200 focus:ring-rss-blue-300 absolute top-0 left-0 py-1 px-2 -mt-3 ml-2 text-xs rounded focus:outline-none focus:ring select-none"-->
<!--                    >-->
<!--                        {{ __('And') }}-->
<!--                    </div>-->
<!--                    <IndigoButton-->
<!--                        button-classes="flex items-center mt-3"-->
<!--                        :disabled="conditionButtonDisabled(conditionSet)"-->
<!--                        @click="addCondition(index)"-->
<!--                    >-->
<!--                        <i class="fas fa-plus mr-2 text-base leading-5" />-->
<!--                        <span class="text-xs">{{ __('And') }}</span>-->
<!--                    </IndigoButton>-->
<!--                </div>-->
<!--            </template>-->
<!--        </div>-->
<!--        <div class="relative p-3 rounded border">-->
<!--            <IndigoButton-->
<!--                button-classes="flex items-center"-->
<!--                :disabled="conditionSetButtonDisabled"-->
<!--                @click="addConditionSet"-->
<!--            >-->
<!--                <i class="fas fa-plus mr-2 text-base leading-5" />-->
<!--                <span class="text-xs">{{ __('Or') }}</span>-->
<!--            </IndigoButton>-->
<!--        </div>-->
<!--        <div class="flex justify-end">-->
<!--            <IndigoButton-->
<!--                button-classes="text-xs"-->
<!--                :disabled="addButtonDisabled"-->
<!--                @click="place"-->
<!--            >-->
<!--                {{ __('Confirm') }}-->
<!--            </IndigoButton>-->
<!--        </div>-->
<!--    </div>-->
<!--</template>-->
