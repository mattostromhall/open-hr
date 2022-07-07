<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import {CalendarIcon, ChevronRightIcon} from '@heroicons/vue/outline'
import {Link} from '@inertiajs/inertia-vue3'

defineProps({
    rejected: {
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
    <div class="sm:px-6 sm:w-full sm:max-w-3xl lg:col-span-9 lg:px-0">
        <div class="bg-white shadow sm:rounded-md">
            <ul
                role="list"
                class="divide-y divide-gray-200"
            >
                <li
                    v-for="(holiday, index) in rejected"
                    :key="index"
                >
                    <Link
                        :href="`/holidays/${holiday.id}`"
                        class="block hover:bg-gray-50"
                    >
                        <div class="flex items-center p-4 sm:px-6">
                            <div class="flex-1 min-w-0 sm:flex sm:justify-between sm:items-center">
                                <div class="w-44 truncate">
                                    <div class="flex text-sm text-indigo-500">
                                        <CalendarIcon class="shrink-0 mr-1.5 w-5 h-5" />
                                        <p>
                                            Starts
                                            {{ formatDate(holiday.start_at) }}
                                        </p>
                                    </div>
                                    <div class="flex mt-2">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <CalendarIcon class="shrink-0 mr-1.5 w-5 h-5 text-gray-400" />
                                            <p v-if="! holiday.half_day">
                                                Finishes
                                                {{ formatDate(holiday.finish_at) }}
                                            </p>
                                            <p
                                                v-else
                                                class="inline-flex px-2 text-xs font-semibold leading-5 text-indigo-800 bg-indigo-100 rounded-full"
                                            >
                                                Half day {{ holiday.half_day }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0 sm:flex sm:justify-between sm:items-center">
                                    <p class="px-3 text-sm text-gray-400 truncate">
                                        {{ holiday.notes }}
                                    </p>
                                </div>
                                <div class="shrink-0 mt-4 sm:mt-0 sm:ml-5">
                                    <p class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                        Rejected
                                    </p>
                                </div>
                            </div>
                            <div class="shrink-0 ml-5">
                                <ChevronRightIcon class="w-5 h-5 text-gray-400" />
                            </div>
                        </div>
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>