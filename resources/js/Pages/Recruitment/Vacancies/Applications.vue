<script setup lang="ts">
import {computed, reactive, ref} from 'vue'
import type {ComputedRef, Ref} from 'vue'
import type {Application, ApplicationStatus} from '../../../types'
import {Link} from '@inertiajs/inertia-vue3'
import CheckboxInput from '@/Components/Controls/CheckboxInput.vue'
import {EnvelopeIcon, EyeIcon, TrashIcon} from '@heroicons/vue/24/outline'
import type {Paginated, Paginator} from '../../../types'
import Pagination from '@/Components/Controls/Pagination.vue'
import {omit} from 'lodash'
import SimpleDropdown from '@/Components/SimpleDropdown.vue'

const props = defineProps<{
    applications: Paginated<Omit<Application, 'cover_letter'>>
}>()

const paginator: ComputedRef<Paginator> = computed(() => omit(props.applications, 'data'))

let selected: Ref<number[]> = ref([])

function updateSelected(isSelected: boolean, id: number) {
    if (isSelected) {
        return selected.value.push(id)
    }

    return selected.value = selected.value.filter(item => item !== id)
}

function toggleSelected(select: boolean) {
    if (select) {
        return selected.value = props.applications.data.map(application => application.id)
    }

    return selected.value = []
}

function isSelected(id: number) {
    return selected.value.includes(id)
}

function status(status: ApplicationStatus): string {
    if (status === 2) {
        return 'successful'
    }

    if (status === 3) {
        return 'unsuccessful'
    }

    return 'pending'
}

const showDeleteDropdown: {[id: number]: boolean} = reactive(Object.fromEntries(
    props.applications.data.map((application) => [application.id, false])
))
</script>

<template>
    <div class="sm:w-full sm:px-6 lg:col-span-9 lg:px-0">
        <div
            v-if="applications.data.length === 0"
            class="bg-white py-6 px-4 text-center shadow sm:max-w-3xl sm:rounded-md sm:p-6"
        >
            <EnvelopeIcon class="mx-auto h-12 w-12 text-gray-400" />
            <h3 class="mt-2 text-sm font-medium text-gray-900">
                No Applications yet!
            </h3>
        </div>
        <div
            v-else
            class="mt-8 flex flex-col"
        >
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="relative overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <div
                            v-show="selected.length"
                            class="absolute top-0 left-12 flex h-12 items-center space-x-3 bg-gray-50 sm:left-16"
                        >
                            <button
                                type="button"
                                class="inline-flex items-center rounded border border-gray-300 bg-white py-1.5 px-2.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-30"
                            >
                                Bulk edit
                            </button>
                            <button
                                type="button"
                                class="inline-flex items-center rounded border border-gray-300 bg-white py-1.5 px-2.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-30"
                            >
                                Delete all
                            </button>
                        </div>

                        <table class="min-w-full table-fixed divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        scope="col"
                                        class="relative w-12 px-6 sm:w-16 sm:px-8"
                                    >
                                        <CheckboxInput
                                            class="absolute top-1/2 left-4 -mt-2"
                                            @checked="toggleSelected"
                                        />
                                    </th>
                                    <th
                                        scope="col"
                                        class="min-w-[12rem] py-3.5 pr-3 text-left text-sm font-semibold text-gray-900"
                                    >
                                        Name
                                    </th>
                                    <th
                                        scope="col"
                                        class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900"
                                    >
                                        Status
                                    </th>
                                    <th
                                        scope="col"
                                        class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900"
                                    >
                                        Contact Number
                                    </th>
                                    <th
                                        scope="col"
                                        class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900"
                                    >
                                        Contact Email
                                    </th>
                                    <th
                                        scope="col"
                                        class="relative py-3.5 pr-4 pl-3 sm:pr-6"
                                    >
                                        <span class="sr-only">Manage</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr
                                    v-for="application in applications.data"
                                    :key="application.id"
                                    :class="{'bg-gray-50': isSelected(application.id)}"
                                >
                                    <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                                        <div
                                            v-show="isSelected(application.id)"
                                            class="absolute inset-y-0 left-0 w-0.5 bg-indigo-600"
                                        />

                                        <CheckboxInput
                                            class="absolute top-1/2 left-4 -mt-2"
                                            :model-value="isSelected(application.id)"
                                            @checked="updateSelected($event, application.id)"
                                        />
                                    </td>
                                    <td
                                        class="whitespace-nowrap py-4 pr-3 text-sm font-medium text-gray-900"
                                        :class="{'text-indigo-600': isSelected(application.id)}"
                                    >
                                        {{ application.name }}
                                    </td>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                        <p
                                            class="inline-flex rounded-full px-2 text-xs font-semibold capitalize leading-5"
                                            :class="{
                                                'bg-blue-100 text-blue-800': application.status === 1,
                                                'bg-green-100 text-green-800': application.status === 2,
                                                'bg-red-100 text-red-800': application.status === 3
                                            }"
                                        >
                                            {{ status(application.status) }}
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                        {{ application.contact_number }}
                                    </td>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                        {{ application.contact_email }}
                                    </td>
                                    <td class="flex justify-end whitespace-nowrap py-4 pr-4 pl-3 text-right text-sm font-medium sm:pr-6">
                                        <div class="flex items-center">
                                            <Link
                                                :href="`/applications/${application.id}`"
                                                class="text-indigo-600 hover:text-indigo-900"
                                            >
                                                <EyeIcon class="h-4 w-4" /><span class="sr-only">, {{ application.name }}</span>
                                            </Link>
                                            <SimpleDropdown
                                                v-model="showDeleteDropdown[application.id]"
                                                class="h-4"
                                                position="above-right"
                                            >
                                                <template #button="{toggleDropdown}">
                                                    <button
                                                        type="button"
                                                        @click="toggleDropdown"
                                                    >
                                                        <TrashIcon class="h-4 w-4 ml-2 text-red-600 hover:text-red-900" /><span class="sr-only">, {{ application.name }}</span>
                                                    </button>
                                                </template>
                                                <template #default="{hideDropdown}">
                                                    <Link
                                                        as="button"
                                                        method="delete"
                                                        :href="`/applications/${application.id}`"
                                                        class="flex justify-center rounded-md border border-transparent bg-red-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:bg-red-400"
                                                        @click="hideDropdown"
                                                    >
                                                        Confirm
                                                    </Link>
                                                </template>
                                            </SimpleDropdown>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <Pagination :paginator="paginator" />
    </div>
</template>