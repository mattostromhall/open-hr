<script setup lang="ts">
import Condition from './ReportCondition.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import type {Report, ReportableColumn, ReportCondition, ReportConditionSet} from '../../types'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import {Head, useForm} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import SearchableSelectInput from '@/Components/Controls/SearchableSelectInput.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import type {ComputedRef, Ref} from 'vue'
import {computed, ref} from 'vue'

const props = defineProps<{
    models: string[],
    reportableColumns: {
        [model: string]: ReportableColumn[]
    }
}>()

const form: InertiaForm<Report> = useForm({
    model: '',
    conditionSets: [
        {
            type: 'and',
            conditions: []
        }
    ]
})

function addConditionSet() {
    form.conditionSets.push({
        type: 'or',
        conditions: []
    })

    modalsOpen.value.push(false)
}

function addCondition(index: number) {
    form.conditionSets[index]?.conditions.push({
        column: '',
        operator: '=',
        value: undefined
    })
}

function removeCondition(conditionSet: ReportConditionSet, index: number) {
    conditionSet.conditions.splice(index, 1)
}

function resetCondition(condition: ReportCondition) {
    condition.column = ''
    condition.operator = '='
    condition.value = undefined
}

function lastConditionInSet(set: ReportConditionSet | undefined): ReportCondition | undefined {
    return set?.conditions[set.conditions.length - 1]
}

function conditionButtonDisabled(conditionSet: ReportConditionSet | undefined): boolean {
    const condition = lastConditionInSet(conditionSet)
    return condition?.column === ''
}

const lastConditionSet: ComputedRef<ReportConditionSet | undefined> = computed(() => form.conditionSets[form.conditionSets.length - 1])
const conditionSetButtonDisabled: ComputedRef<boolean> = computed(() => conditionButtonDisabled(lastConditionSet.value))

const modalsOpen: Ref<boolean[]> = ref([false])

function openModal(index: number) {
    modalsOpen.value.splice(index, 1, true)
}
function closeModal(index: number) {
    modalsOpen.value.splice(index, 1, false)
}

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

    <section class="p-8 space-y-6 sm:w-full sm:max-w-4xl sm:px-6">
        <form @submit.prevent="">
            <div class="shadow sm:rounded-md">
                <div class="space-y-6 bg-white py-6 px-4 sm:rounded-md sm:p-6">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Create a Report
                        </h3>
                    </div>
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            <FormLabel>Report for <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <SearchableSelectInput
                                    v-model="form.model"
                                    :options="models"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 space-y-6">
                        <div
                            v-for="(conditionSet, index) in form.conditionSets"
                            :key="conditionSet"
                            class="relative p-3 pt-8 rounded border"
                        >
                            <template v-if="index === 0">
                                <div
                                    v-for="(condition, conditionIndex) in conditionSet"
                                    :key="condition"
                                    class="flex items-end"
                                >
                                    <Condition
                                        v-if="form.model"
                                        v-model:object="condition.model"
                                        v-model:operator="condition.operator"
                                        v-model:value="condition.value"
                                        :condition="condition"
                                        :models="models"
                                        :reportable-columns="reportableColumns[form.model]"
                                        @update:object="resetCondition(condition)"
                                    />
                                    <button
                                        v-if="conditionSet.conditions.length > 1"
                                        class="flex shrink-0 justify-center items-center mb-3 w-8 h-7 text-red-50 bg-red-700 hover:bg-red-600 rounded focus:outline-none focus:ring focus:ring-red-300 hover:shadow-lg transition duration-300 ease-in-out"
                                        @click="removeCondition(conditionSet, conditionIndex)"
                                    >
                                        <i class="fas fa-trash-alt text-xs" />
                                    </button>
                                </div>
                                <button
                                    v-if="form.conditionSets.length > 1"
                                    class="flex absolute top-0 right-0 justify-center items-center -mt-3 -mr-3 mb-3 w-7 h-6 text-red-50 bg-red-700 hover:bg-red-600 rounded focus:outline-none focus:ring focus:ring-red-300 hover:shadow-lg transition duration-300 ease-in-out"
                                    @click="openModal(index)"
                                >
                                    <i class="text-2xs fas fa-trash-alt" />
                                    <!--                    <ConfirmationModal-->
                                    <!--                        v-if="modalsOpen[index]"-->
                                    <!--                        :model-value="modalsOpen[index]"-->
                                    <!--                        :on-confirm="() => removeConditionSet(index)"-->
                                    <!--                        confirmation-button="RedButton"-->
                                    <!--                        modal-id="removeConditionSetModal"-->
                                    <!--                        confirmation-button-dusk-selector="removeConditionSet"-->
                                    <!--                        @update:model0-value="closeModal(index)"-->
                                    <!--                    >-->
                                    <!--                        <template #header>-->
                                    <!--                            Remove condition set') }}-->
                                    <!--                        </template>-->
                                    <!--                        <div class="w-60 text-center">-->
                                    <!--                            <p>Are you sure?</p>-->
                                    <!--                        </div>-->
                                    <!--                        <template #close-button>-->
                                    <!--                            Cancel-->
                                    <!--                        </template>-->
                                    <!--                        <template #confirm-button>-->
                                    <!--                            Remove-->
                                    <!--                        </template>-->
                                    <!--                    </ConfirmationModal>-->
                                </button>
                                <IndigoButton
                                    button-classes="flex items-center mt-3"
                                    :disabled="conditionButtonDisabled(conditionSet)"
                                    @click="addCondition(index)"
                                >
                                    <i class="fas fa-plus mr-2 text-base leading-5" />
                                    <span class="text-xs">And</span>
                                </IndigoButton>
                            </template>
                            <template v-else>
                                <div class="bg-indigo-200 focus:ring-indigo-300 absolute top-0 left-0 py-1 px-2 -mt-3 ml-2 text-xs rounded focus:outline-none focus:ring select-none">
                                    Or
                                </div>
                                <button
                                    class="flex absolute top-0 right-0 justify-center items-center -mt-3 -mr-3 mb-3 w-7 h-6 text-red-50 bg-red-700 hover:bg-red-600 rounded focus:outline-none focus:ring focus:ring-red-300 hover:shadow-lg transition duration-300 ease-in-out"
                                    @click="openModal(index)"
                                >
                                    <i class="text-2xs fas fa-trash-alt" />
                                    <!--                                <ConfirmationModal-->
                                    <!--                                    v-if="modalsOpen[index]"-->
                                    <!--                                    :model-value="modalsOpen[index]"-->
                                    <!--                                    :on-confirm="() => removeConditionSet(index)"-->
                                    <!--                                    confirmation-button="RedButton"-->
                                    <!--                                    modal-id="removeConditionSetModal"-->
                                    <!--                                    confirmation-button-dusk-selector="removeConditionSet"-->
                                    <!--                                    @update:modelValue="closeModal(index)"-->
                                    <!--                                >-->
                                    <!--                                    <template #header>-->
                                    <!--                                        Remove condition set') }}-->
                                    <!--                                    </template>-->
                                    <!--                                    <div class="w-60 text-center">-->
                                    <!--                                        <p>Are you sure?</p>-->
                                    <!--                                    </div>-->
                                    <!--                                    <template #close-button>-->
                                    <!--                                        Cancel-->
                                    <!--                                    </template>-->
                                    <!--                                    <template #confirm-button>-->
                                    <!--                                        Remove-->
                                    <!--                                    </template>-->
                                    <!--                                </ConfirmationModal>-->
                                </button>
                                <div class="relative p-3 pt-8 rounded border">
                                    <div
                                        v-for="(condition, conditionIndex) in conditionSet"
                                        :key="condition"
                                        class="flex items-end"
                                    >
                                        <Condition
                                            v-if="form.model"
                                            v-model:object="condition.model"
                                            v-model:operator="condition.operator"
                                            v-model:value="condition.value"
                                            :condition="condition"
                                            :models="models"
                                            :reportable-columns="reportableColumns[form.model]"
                                            @update:object="resetCondition(condition)"
                                        />
                                        <button
                                            v-if="conditionSet.conditions.length > 1"
                                            class="flex shrink-0 justify-center items-center mb-3 w-8 h-7 text-red-50 bg-red-700 hover:bg-red-600 rounded focus:outline-none focus:ring focus:ring-red-300 hover:shadow-lg transition duration-300 ease-in-out"
                                            @click="removeCondition(conditionSet, conditionIndex)"
                                        >
                                            <i class="fas fa-trash-alt text-xs" />
                                        </button>
                                    </div>
                                    <div
                                        v-show="conditionSet.conditions.length > 1"
                                        class="bg-indigo-200 focus:ring-indigo-300 absolute top-0 left-0 py-1 px-2 -mt-3 ml-2 text-xs rounded focus:outline-none focus:ring select-none"
                                    >
                                        And
                                    </div>
                                    <IndigoButton
                                        button-classes="flex items-center mt-3"
                                        :disabled="conditionButtonDisabled(conditionSet)"
                                        @click="addCondition(index)"
                                    >
                                        <i class="fas fa-plus mr-2 text-base leading-5" />
                                        <span class="text-xs">And</span>
                                    </IndigoButton>
                                </div>
                            </template>
                        </div>
                        <div class="relative p-3 rounded border">
                            <IndigoButton
                                button-classes="flex items-center"
                                :disabled="conditionSetButtonDisabled"
                                @click="addConditionSet"
                            >
                                <i class="fas fa-plus mr-2 text-base leading-5" />
                                <span class="text-xs">Or</span>
                            </IndigoButton>
                        </div>
                        <div class="flex justify-end">
                            <IndigoButton button-classes="text-xs">
                                Confirm
                            </IndigoButton>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>