<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import {CalendarIcon, ChevronRightIcon, PlusIcon, UsersIcon} from '@heroicons/vue/24/outline'
import {Link} from '@inertiajs/inertia-vue3'
import type {OneToOne, OneToOneStatus} from '../../../types'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import usePermissions from '../../../Hooks/usePermissions'

defineProps<{
    oneToOnes: OneToOne[]
}>()

const {can} = usePermissions()

const emit = defineEmits(['setActive'])

const statusMap = {
    1: 'invited',
    2: 'accepted',
    3: 'declined'
}

function formatDate(date: string): string {
    const formatted = useDateFormat(date, 'DD/MM/YYYY HH:mm')

    return formatted.value
}

function status(status: OneToOneStatus): string {
    return statusMap[status]
}

function requestOneToOne() {
    emit('setActive', 'request')
}
</script>

<template>
    <div class="sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0">
        <div
            v-if="oneToOnes.length === 0"
            class="bg-white py-6 px-4 text-center shadow sm:rounded-md sm:p-6"
        >
            <UsersIcon class="mx-auto h-12 w-12 text-gray-400" />
            <h3 class="mt-2 text-sm font-medium text-gray-900">
                No Previous One-to-ones
            </h3>
            <div
                v-if="can('create-one-to-one')"
                class="mt-6 flex justify-center"
            >
                <IndigoButton @click="requestOneToOne">
                    <PlusIcon class="mr-2 -ml-1 h-5 w-5" />
                    Request
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
                    v-for="(oneToOne, index) in oneToOnes"
                    :key="index"
                >
                    <Link
                        :href="`/one-to-ones/${oneToOne.id}`"
                        class="block hover:bg-gray-50"
                    >
                        <div class="flex items-center p-4 sm:px-6">
                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                <div class="w-60 truncate">
                                    <div class="flex text-sm text-indigo-500">
                                        <CalendarIcon class="mr-1.5 h-5 w-5 shrink-0" />
                                        <p>
                                            Scheduled at
                                            {{ formatDate(oneToOne.scheduled_at) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                    <p class="truncate px-3 text-sm text-gray-400">
                                        {{ oneToOne.notes }}
                                    </p>
                                </div>
                                <div class="mt-4 shrink-0 sm:mt-0 sm:ml-5">
                                    <p
                                        class="inline-flex rounded-full px-2 text-xs font-semibold capitalize leading-5"
                                        :class="{
                                            'bg-blue-100 text-blue-800': status(oneToOne.status) === 'invited',
                                            'bg-green-100 text-green-800': status(oneToOne.status) === 'accepted',
                                            'bg-red-100 text-red-800': status(oneToOne.status) === 'declined'
                                        }"
                                    >
                                        {{ status(oneToOne.status) }}
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