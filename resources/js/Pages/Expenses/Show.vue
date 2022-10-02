<script setup lang="ts">
import type {DocumentListItem, Expense} from '../../types'
import {useDateFormat} from '@vueuse/core'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import {computed} from 'vue'
import DocumentList from '../Files/Documents/DocumentList.vue'

const props = defineProps<{
    expense: Expense,
    requester: string,
    documents: DocumentListItem[]
}>()

const statusMap = {
    1: 'pending',
    2: 'approved',
    3: 'rejected'
}

const status = computed(() => statusMap[props.expense.status])
</script>

<template>
    <Head>
        <title>View Expense</title>
    </Head>

    <PageHeading>
        <span class="font-medium">Viewing</span> - Expense
        <template #link>
            <LightIndigoLink :href="`/expenses/${expense.id}/edit`">
                Edit
            </LightIndigoLink>
        </template>
    </PageHeading>
    <section class="w-full p-8 sm:max-w-6xl">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="py-5 px-4 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Expense Information
                </h3>
            </div>
            <div class="border-t border-gray-200 py-5 px-4 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Requested by
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ requester }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Status
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <p
                                class="inline-flex rounded-full px-2 text-xs font-semibold leading-5"
                                :class="{
                                    'text-blue-800 bg-blue-100': status === 'pending',
                                    'text-green-800 bg-green-100': status === 'approved',
                                    'text-red-800 bg-red-100': status === 'rejected'
                                }"
                            >
                                {{ status }}
                            </p>
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Date
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ useDateFormat(expense.date, 'DD/MM/YYYY').value }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Value
                        </dt>
                        <dd class="mt-1 text-sm uppercase text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ expense.value }} {{ expense.value_currency }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Notes
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ expense.notes ?? '-' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
        <DocumentList
            class="mt-6"
            :items="documents"
        />
    </section>
</template>