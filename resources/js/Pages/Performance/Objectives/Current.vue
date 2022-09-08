<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import {CalendarIcon, ChevronRightIcon, SparklesIcon} from '@heroicons/vue/outline'
import {Link} from '@inertiajs/inertia-vue3'
import type {Objective} from '../../../types'

defineProps<{
    objectives: Objective[]
}>()

function overdue(objective: Objective): boolean {
    return objective.days_remaining < 0
}
</script>

<template>
    <div class="sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0">
        <div
            v-if="objectives.length === 0"
            class="bg-white py-6 px-4 text-center shadow sm:rounded-md sm:p-6"
        >
            <SparklesIcon class="mx-auto h-12 w-12 text-gray-400" />
            <h3 class="mt-2 text-sm font-medium text-gray-900">
                No active Objectives!
            </h3>
        </div>
        <div
            v-else
            class="bg-white shadow sm:rounded-md"
        >
            <ul
                role="list"
                class="divide-y divide-gray-200"
            >
                <li
                    v-for="(objective, index) in objectives"
                    :key="index"
                >
                    <Link
                        :href="`/objectives/${objective.id}`"
                        class="block hover:bg-gray-50"
                    >
                        <div class="flex items-center p-4 sm:px-6">
                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                <div class="w-60 truncate">
                                    <div class="flex text-sm text-indigo-500">
                                        <CalendarIcon class="mr-1.5 h-5 w-5 shrink-0" />
                                        <p>
                                            Due
                                            {{ useDateFormat(objective.due_at, 'DD/MM/YYYY').value }}
                                        </p>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                    <p class="truncate px-3 text-sm text-gray-400">
                                        {{ objective.title }}
                                    </p>
                                </div>
                                <div class="mt-4 shrink-0 sm:mt-0 sm:ml-5">
                                    <p
                                        class="inline-flex rounded-full px-2 text-xs font-semibold capitalize leading-5"
                                        :class="{
                                            'bg-blue-100 text-blue-800': ! overdue(objective),
                                            'bg-red-100 text-red-800': overdue(objective)
                                        }"
                                    >
                                        {{ ! overdue(objective) ? `${objective.days_remaining} days remaining` : 'overdue' }}
                                    </p>
                                </div>
                            </div>
                            <div class="ml-5 shrink-0">
                                <ChevronRightIcon class="h-5 w-5 text-gray-400" />
                            </div>
                        </div>
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>