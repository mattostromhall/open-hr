<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import {CheckCircleIcon, ClockIcon, QuestionMarkCircleIcon, XCircleIcon} from '@heroicons/vue/24/outline'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import type {Expense, SelectOption} from '../../types'
import Submit from './Submit.vue'

interface ExpenseWithType extends Expense {
    type: string
}

defineProps<{
    expenseTypes: SelectOption[],
    approved: ExpenseWithType[],
    pending: ExpenseWithType[],
    rejected: ExpenseWithType[]
}>()

type ActiveTab = 'submit' | 'approved' | 'pending' | 'rejected'

const activeTab: Ref<ActiveTab> = ref('submit')

function setActive(tab: ActiveTab): void {
    activeTab.value = tab
}

function isActive(tab: string): boolean {
    return activeTab.value === tab
}
</script>

<template>
    <Head>
        <title>Manage Expenses</title>
    </Head>

    <PageHeading>
        Expenses
        <template #link>
            <LightIndigoLink href="/dashboard">
                Dashboard
            </LightIndigoLink>
        </template>
    </PageHeading>
    <div class="p-8 lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:col-span-3 lg:p-0">
            <nav class="space-y-1">
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('submit'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('submit')
                    }"
                    aria-current="page"
                    @click="setActive('submit')"
                >
                    <ClockIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('submit'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('submit')
                        }"
                    />
                    <span class="truncate">Submit an Expense</span>
                </button>
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('approved'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('approved')
                    }"
                    aria-current="page"
                    @click="setActive('approved')"
                >
                    <CheckCircleIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('approved'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('approved')
                        }"
                    />
                    <span class="truncate">Approved</span>
                </button>
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('pending'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('pending')
                    }"
                    @click="setActive('pending')"
                >
                    <QuestionMarkCircleIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('pending'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('pending')
                        }"
                    />
                    <span class="truncate">Pending</span>
                </button>
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('rejected'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('rejected')
                    }"
                    @click="setActive('rejected')"
                >
                    <XCircleIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('rejected'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('rejected')
                        }"
                    />
                    <span class="truncate">Rejected</span>
                </button>
            </nav>
        </aside>
        <Submit :expense-types="expenseTypes" />
    </div>
</template>