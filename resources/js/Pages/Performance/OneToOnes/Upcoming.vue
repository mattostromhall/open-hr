<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import {CalendarIcon, ChevronRightIcon} from '@heroicons/vue/outline'
import {Link} from '@inertiajs/inertia-vue3'

defineProps({
    approved: {
        type: Array,
        default: () => []
    }
})

function formatDate(date: string): string {
    const formatted = useDateFormat(date, 'DD/MM/YYYY')

    return formatted.value
}
</script>

<template>
    <div class="sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0">
        <div class="bg-white shadow sm:rounded-md">
            <ul
                role="list"
                class="divide-y divide-gray-200"
            >
                <li
                    v-for="(oneToOne, index) in approved"
                    :key="index"
                >
                    <Link
                        :href="`/holidays/${holiday.id}`"
                        class="block hover:bg-gray-50"
                    >
                        <div class="flex items-center p-4 sm:px-6">
                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                <div class="w-44 truncate">
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