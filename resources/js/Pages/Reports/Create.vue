<script setup lang="ts">
import {BookmarkSquareIcon, ExclamationTriangleIcon, PlusSmallIcon, TrashIcon} from '@heroicons/vue/24/outline'
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
import SimpleModal from '@/Components/SimpleModal.vue'
import GreyOutlineButton from '@/Components/Controls/GreyOutlineButton.vue'
import RedButton from '@/Components/Controls/RedButton.vue'
import TextInput from '@/Components/Controls/TextInput.vue'

defineProps<{
    models: string[],
    reportableColumns: {
        [model: string]: ReportableColumn[]
    },
    downloadPath?: string
}>()

type ReportData = Omit<Report, 'id' | 'label' | 'last_ran'> & {label?: string}

const form: InertiaForm<ReportData> = useForm({
    label: undefined,
    model: '',
    condition_sets: [
        {
            type: 'and',
            conditions: [
                {
                    column: '',
                    operator: '=',
                    value: undefined
                }
            ]
        }
    ]
})

function addConditionSet() {
    form.condition_sets.push({
        type: 'or',
        conditions: [
            {
                column: '',
                operator: '=',
                value: undefined
            }
        ]
    })

    modalsOpen.value.push(false)
}

function removeConditionSet(index: number) {
    form.condition_sets.splice(index, 1)
    modalsOpen.value.splice(index, 1)
}

function addCondition(index: number) {
    form.condition_sets[index]?.conditions.push({
        column: '',
        operator: '=',
        value: undefined
    })
}

function removeCondition(conditionSet: ReportConditionSet, index: number) {
    conditionSet.conditions.splice(index, 1)
}

function reset() {
    form.label = undefined
    form.model = ''
    form.condition_sets = [
        {
            type: 'and',
            conditions: []
        }
    ]
}

function lastConditionInSet(set: ReportConditionSet | undefined): ReportCondition | undefined {
    return set?.conditions[set.conditions.length - 1]
}

function conditionButtonDisabled(conditionSet: ReportConditionSet | undefined): boolean {
    const condition = lastConditionInSet(conditionSet)
    return condition?.column === ''
}

const lastConditionSet: ComputedRef<ReportConditionSet | undefined> = computed(() => form.condition_sets[form.condition_sets.length - 1])
const conditionSetButtonDisabled: ComputedRef<boolean> = computed(() => conditionButtonDisabled(lastConditionSet.value))

const modalsOpen: Ref<boolean[]> = ref([false])

function openModal(index: number) {
    modalsOpen.value.splice(index, 1, true)
}
function closeModal(index: number) {
    modalsOpen.value.splice(index, 1, false)
}

const saveModalOpen: Ref<boolean> = ref(false)

function save() {
    if (form.label === undefined) {
        form.label = ''
    }

    form.post('/reports')
}

function generate() {
    if (form.label === '') {
        form.label = undefined
    }

    form.post('/reports/generate')
}
</script>

<template>
    <Head>
        <title>Reporting</title>
    </Head>

    <PageHeading>
        Create Report
        <template #link>
            <LightIndigoLink href="/reports">
                All Reports
            </LightIndigoLink>
        </template>
    </PageHeading>

    <section class="p-8 space-y-6 sm:w-full sm:max-w-4xl sm:px-6">
        <form @submit.prevent="generate">
            <div class="shadow sm:rounded-md">
                <div class="bg-white py-6 px-4 sm:rounded-md sm:p-6">
                    <div class="flex justify-between">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Create a Report
                        </h3>
                        <IndigoButton
                            class="!px-2 !py-1 text-xs"
                            type="button"
                            @click="reset"
                        >
                            Reset
                        </IndigoButton>
                    </div>
                    <div class="grid grid-cols-6 gap-6 mt-6 mb-12">
                        <div class="col-span-6">
                            <FormLabel>Report on <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <SearchableSelectInput
                                    v-model="form.model"
                                    :options="models"
                                />
                            </div>
                        </div>
                    </div>
                    <div
                        v-if="form.model"
                        class="mt-6 space-y-6"
                    >
                        <div
                            v-for="(conditionSet, index) in form.condition_sets"
                            :key="conditionSet"
                            class="relative p-3 pt-8 rounded-md border"
                        >
                            <template v-if="index === 0">
                                <div
                                    v-for="(condition, conditionIndex) in conditionSet.conditions"
                                    :key="condition"
                                    class="flex items-end"
                                >
                                    <Condition
                                        v-model:column="condition.column"
                                        v-model:operator="condition.operator"
                                        v-model:value="condition.value"
                                        :condition="condition"
                                        :models="models"
                                        :reportable-columns="reportableColumns[form.model]"
                                        :column-error="form.errors[`condition_sets.${index}.conditions.${conditionIndex}.column`]"
                                        :operator-error="form.errors[`condition_sets.${index}.conditions.${conditionIndex}.operator`]"
                                        :column-value="form.errors[`condition_sets.${index}.conditions.${conditionIndex}.value`]"
                                    />
                                    <button
                                        v-if="conditionSet.conditions.length > 1"
                                        class="flex shrink-0 justify-center items-center mb-3 w-8 h-7 text-red-50 bg-red-700 hover:bg-red-600 rounded-md focus:outline-none focus:ring focus:ring-red-300 hover:shadow-lg transition duration-300 ease-in-out"
                                        @click="removeCondition(conditionSet, conditionIndex)"
                                    >
                                        <TrashIcon class="w-3.5 h-3.5" />
                                    </button>
                                </div>
                                <button
                                    v-if="form.condition_sets.length > 1"
                                    class="flex absolute top-0 right-0 justify-center items-center -mt-3 -mr-3 mb-3 w-7 h-6 text-red-50 bg-red-700 hover:bg-red-600 rounded focus:outline-none focus:ring focus:ring-red-300 hover:shadow-lg transition duration-300 ease-in-out"
                                    @click="openModal(index)"
                                >
                                    <TrashIcon class="w-3.5 h-3.5" />
                                    <SimpleModal
                                        v-model="modalsOpen[index]"
                                        modal-classes="px-4 pt-5 pb-4 text-left sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                                    >
                                        <div class="sm:flex sm:items-start">
                                            <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <ExclamationTriangleIcon class="h-6 w-6 text-red-600" />
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <h3
                                                    id="modal-title"
                                                    class="text-lg font-medium leading-6 text-gray-900"
                                                >
                                                    Confirm Delete
                                                </h3>
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-500">
                                                        Are you sure you want to remove this condition set? This action cannot be undone.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                            <RedButton
                                                type="button"
                                                class="w-full sm:w-auto sm:ml-3"
                                                @click="removeConditionSet(index)"
                                            >
                                                Confirm
                                            </RedButton>
                                            <GreyOutlineButton
                                                class="w-full sm:w-auto mt-3 sm:mt-0"
                                                @click="closeModal(index)"
                                            >
                                                Cancel
                                            </GreyOutlineButton>
                                        </div>
                                    </SimpleModal>
                                </button>
                                <IndigoButton
                                    button-classes="flex items-center mt-3"
                                    :disabled="conditionButtonDisabled(conditionSet)"
                                    @click="addCondition(index)"
                                >
                                    <PlusSmallIcon class="w-4 h-4 mr-1" />
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
                                    <TrashIcon class="w-3.5 h-3.5" />
                                    <SimpleModal
                                        v-model="modalsOpen[index]"
                                        modal-classes="px-4 pt-5 pb-4 text-left sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                                    >
                                        <div class="sm:flex sm:items-start">
                                            <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <ExclamationTriangleIcon class="h-6 w-6 text-red-600" />
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <h3
                                                    id="modal-title"
                                                    class="text-lg font-medium leading-6 text-gray-900"
                                                >
                                                    Confirm Delete
                                                </h3>
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-500">
                                                        Are you sure you want to remove this condition set? This action cannot be undone.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                            <RedButton
                                                type="button"
                                                class="w-full sm:w-auto sm:ml-3"
                                                @click="removeConditionSet(index)"
                                            >
                                                Confirm
                                            </RedButton>
                                            <GreyOutlineButton
                                                class="w-full sm:w-auto mt-3 sm:mt-0"
                                                @click="closeModal(index)"
                                            >
                                                Cancel
                                            </GreyOutlineButton>
                                        </div>
                                    </SimpleModal>
                                </button>
                                <div class="relative p-3 pt-8 rounded-md border">
                                    <div
                                        v-for="(condition, conditionIndex) in conditionSet.conditions"
                                        :key="condition"
                                        class="flex items-end"
                                    >
                                        <Condition
                                            v-model:column="condition.column"
                                            v-model:operator="condition.operator"
                                            v-model:value="condition.value"
                                            :condition="condition"
                                            :models="models"
                                            :reportable-columns="reportableColumns[form.model]"
                                            :column-error="form.errors[`condition_sets.${index}.conditions.${conditionIndex}.column`]"
                                            :operator-error="form.errors[`condition_sets.${index}.conditions.${conditionIndex}.operator`]"
                                            :column-value="form.errors[`condition_sets.${index}.conditions.${conditionIndex}.value`]"
                                        />
                                        <button
                                            v-if="conditionSet.conditions.length > 1"
                                            class="flex shrink-0 justify-center items-center mb-3 w-8 h-7 text-red-50 bg-red-700 hover:bg-red-600 rounded focus:outline-none focus:ring focus:ring-red-300 hover:shadow-lg transition duration-300 ease-in-out"
                                            @click="removeCondition(conditionSet, conditionIndex)"
                                        >
                                            <TrashIcon class="w-3.5 h-3.5" />
                                        </button>
                                    </div>
                                    <div
                                        v-show="conditionSet.conditions.length > 1"
                                        class="bg-indigo-200 focus:ring-indigo-300 absolute top-0 left-0 py-1 px-2 -mt-3 ml-2 text-xs rounded-md focus:outline-none focus:ring select-none"
                                    >
                                        And
                                    </div>
                                    <IndigoButton
                                        button-classes="flex items-center mt-3"
                                        :disabled="conditionButtonDisabled(conditionSet)"
                                        @click="addCondition(index)"
                                    >
                                        <PlusSmallIcon class="w-4 h-4 mr-1" />
                                        <span class="text-xs">And</span>
                                    </IndigoButton>
                                </div>
                            </template>
                        </div>
                        <div class="relative p-3 rounded-md border">
                            <IndigoButton
                                button-classes="flex items-center"
                                :disabled="conditionSetButtonDisabled"
                                @click="addConditionSet"
                            >
                                <PlusSmallIcon class="w-4 h-4 mr-1" />
                                <span class="text-xs">Or</span>
                            </IndigoButton>
                        </div>
                        <div class="flex space-x-2 justify-end">
                            <IndigoButton
                                type="button"
                                button-classes="text-xs"
                                @click="saveModalOpen = true"
                            >
                                Save
                                <SimpleModal
                                    v-model="saveModalOpen"
                                    modal-classes="px-4 pt-5 pb-4 text-left sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                                >
                                    <div class="sm:flex sm:items-start">
                                        <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <BookmarkSquareIcon class="h-6 w-6 text-green-600" />
                                        </div>
                                        <div class="my-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3
                                                id="modal-title"
                                                class="text-lg font-medium leading-6 text-gray-900 mb-2"
                                            >
                                                Save Report
                                            </h3>
                                            <FormLabel class="!text-gray-500">
                                                Please provide a label for reference in the future <RequiredIcon />
                                            </FormLabel>
                                            <div class="mt-1">
                                                <TextInput
                                                    v-model="form.label"
                                                    :error="form.errors.label"
                                                    input-id="report-label"
                                                    input-name="report-label"
                                                    @reset="form.clearErrors('label')"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                        <IndigoButton
                                            type="button"
                                            class="w-full sm:w-auto sm:ml-3"
                                            @click="save"
                                        >
                                            Save
                                        </IndigoButton>
                                        <GreyOutlineButton
                                            class="w-full sm:w-auto mt-3 sm:mt-0"
                                            @click="saveModalOpen = false"
                                        >
                                            Cancel
                                        </GreyOutlineButton>
                                    </div>
                                </SimpleModal>
                            </IndigoButton>
                            <IndigoButton button-classes="text-xs">
                                Generate
                            </IndigoButton>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>