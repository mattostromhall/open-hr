<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import {BookOpenIcon, CalendarIcon, ChevronRightIcon, PlusIcon} from '@heroicons/vue/24/outline'
import {Link} from '@inertiajs/inertia-vue3'
import type {Vacancy} from '../../../types'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'

defineProps<{
    closed: (Pick<Vacancy, 'id' | 'title' | 'location' | 'contract_type' | 'open_at' | 'close_at'>)[]
}>()

const emit = defineEmits(['setActive'])

function formatDate(date: string): string {
    const formatted = useDateFormat(date, 'DD/MM/YYYY')

    return formatted.value
}

function postVacancy() {
    emit('setActive', 'post')
}
</script>

<template>
    <div class="sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0">
        <div
            v-if="closed.length === 0"
            class="bg-white py-6 px-4 text-center shadow sm:rounded-md sm:p-6"
        >
            <BookOpenIcon class="mx-auto h-12 w-12 text-gray-400" />
            <h3 class="mt-2 text-sm font-medium text-gray-900">
                No Closed Vacancies
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Post a new Vacancy for your Organisation.
            </p>
            <div class="mt-6 flex justify-center">
                <IndigoButton @click="postVacancy">
                    <PlusIcon class="mr-2 -ml-1 h-5 w-5" />
                    Post
                </IndigoButton>
            </div>
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
                    v-for="(vacancy, index) in closed"
                    :key="index"
                >
                    <Link
                        :href="`/vacancies/${vacancy.id}`"
                        class="block hover:bg-gray-50"
                    >
                        <div class="flex items-center p-4 sm:px-6">
                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                <div class="w-44 truncate">
                                    <div class="flex text-sm text-indigo-500">
                                        <CalendarIcon class="mr-1.5 h-5 w-5 shrink-0" />
                                        <p>
                                            Opens
                                            {{ formatDate(vacancy.open_at) }}
                                        </p>
                                    </div>
                                    <div class="mt-2 flex">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <CalendarIcon class="mr-1.5 h-5 w-5 shrink-0 text-gray-400" />
                                            <p>
                                                Closes
                                                {{ formatDate(vacancy.close_at) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                    <p class="truncate px-3 text-sm text-gray-400">
                                        {{ vacancy.title }} - <span class="capitalize">{{ vacancy.contract_type }}</span>, {{ vacancy.location }}
                                    </p>
                                </div>
                                <div class="mt-4 shrink-0 sm:mt-0 sm:ml-5">
                                    <p class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                                        Open
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