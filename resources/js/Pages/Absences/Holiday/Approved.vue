<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import {CalendarIcon, CheckCircleIcon, ChevronRightIcon} from '@heroicons/vue/24/outline'
import {Link} from '@inertiajs/vue3'
import type {Holiday} from '../../../types'

const props = defineProps<{
    approved: (Pick<Holiday, 'id' | 'start_at' | 'finish_at' | 'half_day' | 'notes'> & {duration: number})[],
    managing?: boolean
}>()

function formatDate(date: string): string {
    const formatted = useDateFormat(date, 'DD/MM/YYYY')

    return formatted.value
}

function linkTarget(holidayId: number): string {
    return `/holidays/${holidayId}${props.managing ? '/review' : ''}`
}
</script>

<template>
    <div class="sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0">
        <div
            v-if="approved.length === 0"
            class="bg-white py-6 px-4 text-center shadow sm:rounded-md sm:p-6"
        >
            <CheckCircleIcon class="mx-auto h-12 w-12 text-gray-400" />
            <h3 class="mt-2 text-sm font-medium text-gray-900">
                No approved Holidays!
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
                    v-for="(holiday, index) in approved"
                    :key="index"
                >
                    <Link
                        :href="linkTarget(holiday.id)"
                        class="block hover:bg-gray-50"
                    >
                        <div class="flex items-center p-4 sm:px-6">
                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                <div class="group w-44 relative">
                                    <div class="flex text-sm text-indigo-500">
                                        <CalendarIcon class="mr-1.5 h-5 w-5 shrink-0" />
                                        <p>
                                            Starts
                                            {{ formatDate(holiday.start_at) }}
                                        </p>
                                    </div>
                                    <div class="mt-2 flex">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <CalendarIcon class="mr-1.5 h-5 w-5 shrink-0 text-gray-400" />
                                            <p v-if="! holiday.half_day">
                                                Finishes
                                                {{ formatDate(holiday.finish_at) }}
                                            </p>
                                            <p
                                                v-else
                                                class="inline-flex rounded-full bg-indigo-100 px-2 text-xs font-semibold leading-5 text-indigo-800"
                                            >
                                                Half day {{ holiday.half_day }}
                                            </p>
                                        </div>
                                    </div>
                                    <span class="group-hover:block hidden bg-indigo-500 text-white py-1 px-2 rounded absolute text-xs z-10 -top-7 right-0">
                                        {{ holiday.duration > 1 ? `${holiday.duration} days` : `${holiday.duration} day` }}
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                    <p class="truncate px-3 text-sm text-gray-400">
                                        {{ holiday.notes }}
                                    </p>
                                </div>
                                <div class="mt-4 shrink-0 sm:mt-0 sm:ml-5">
                                    <p class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                                        Approved
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