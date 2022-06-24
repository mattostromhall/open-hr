<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import {ref} from 'vue'
import type {Ref} from 'vue'
import {hasOwnProperty} from '../../types'
import {Link} from '@inertiajs/inertia-vue3'
import IndigoLink from '@/Components/Controls/IndigoLink.vue'
import PageHeading from '@/Components/PageHeading.vue'
import CheckboxInput from '@/Components/Controls/CheckboxInput.vue'

const props = defineProps({
    people: {
        type: Array,
        default: () => []
    }
})

let selected: Ref<number[]> = ref([])

function updateSelected(isSelected: boolean, id: number) {
    if (isSelected) {
        return selected.value.push(id)
    }

    return selected.value = selected.value.filter(item => item !== id)
}

function toggleSelected(select: boolean) {
    if (select) {
        return selected.value = props.people.map(person => {
            if (typeof person === 'object'
                && person
                && hasOwnProperty(person, 'id')
            ) {
                return person.id
            }
        }) as number[]
    }

    return selected.value = []
}

function isSelected(id: number) {
    return selected.value.includes(id)
}
</script>

<template>
    <Head title="People" />

    <PageHeading>
        People
        <template #link>
            <IndigoLink href="/people/create">
                Add person
            </IndigoLink>
        </template>
    </PageHeading>
    <div class="p-8">
        <div class="flex flex-col mt-8">
            <div class="overflow-x-auto -my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                <div class="inline-block py-2 min-w-full align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden relative ring-1 ring-black ring-opacity-5 shadow md:rounded-lg">
                        <div
                            v-show="selected.length"
                            class="flex absolute top-0 left-12 items-center space-x-3 h-12 bg-gray-50 sm:left-16"
                        >
                            <button
                                type="button"
                                class="inline-flex items-center py-1.5 px-2.5 text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-sm disabled:opacity-30 disabled:cursor-not-allowed"
                            >
                                Bulk edit
                            </button>
                            <button
                                type="button"
                                class="inline-flex items-center py-1.5 px-2.5 text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-sm disabled:opacity-30 disabled:cursor-not-allowed"
                            >
                                Delete all
                            </button>
                        </div>

                        <table class="min-w-full divide-y divide-gray-300 table-fixed">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        scope="col"
                                        class="relative px-6 w-12 sm:px-8 sm:w-16"
                                    >
                                        <CheckboxInput
                                            class="absolute top-1/2 left-4 -mt-2"
                                            @checked="toggleSelected"
                                        />
                                    </th>
                                    <th
                                        scope="col"
                                        class="py-3.5 pr-3 min-w-[12rem] text-sm font-semibold text-left text-gray-900"
                                    >
                                        Name
                                    </th>
                                    <th
                                        scope="col"
                                        class="py-3.5 px-3 text-sm font-semibold text-left text-gray-900"
                                    >
                                        Pronouns
                                    </th>
                                    <th
                                        scope="col"
                                        class="py-3.5 px-3 text-sm font-semibold text-left text-gray-900"
                                    >
                                        Email
                                    </th>
                                    <th
                                        scope="col"
                                        class="py-3.5 px-3 text-sm font-semibold text-left text-gray-900"
                                    >
                                        Position
                                    </th>
                                    <th
                                        scope="col"
                                        class="py-3.5 px-3 text-sm font-semibold text-left text-gray-900"
                                    >
                                        Department
                                    </th>
                                    <th
                                        scope="col"
                                        class="relative py-3.5 pr-4 pl-3 sm:pr-6"
                                    >
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="{id, email, person} in people"
                                    :key="person.id"
                                    :class="{'bg-gray-50': isSelected(id)}"
                                >
                                    <td class="relative px-6 w-12 sm:px-8 sm:w-16">
                                        <div
                                            v-show="isSelected(id)"
                                            class="absolute inset-y-0 left-0 w-0.5 bg-indigo-600"
                                        />

                                        <CheckboxInput
                                            class="absolute top-1/2 left-4 -mt-2"
                                            :model-value="isSelected(id)"
                                            @checked="updateSelected($event, id)"
                                        />
                                    </td>
                                    <td
                                        class="py-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap"
                                        :class="{'text-indigo-600': isSelected(id)}"
                                    >
                                        {{ person.full_name }}
                                    </td>
                                    <td class="py-4 px-3 text-sm text-gray-500 whitespace-nowrap">
                                        {{ person.pronouns }}
                                    </td>
                                    <td class="py-4 px-3 text-sm text-gray-500 whitespace-nowrap">
                                        {{ email }}
                                    </td>
                                    <td class="py-4 px-3 text-sm text-gray-500 whitespace-nowrap">
                                        {{ person.position }}
                                    </td>
                                    <td class="py-4 px-3 text-sm text-gray-500 whitespace-nowrap">
                                        {{ person.department?.name ?? '-' }}
                                    </td>
                                    <td class="py-4 pr-4 pl-3 text-sm font-medium text-right whitespace-nowrap sm:pr-6">
                                        <Link
                                            :href="`/people/${person.id}/edit`"
                                            class="text-indigo-600 hover:text-indigo-900"
                                        >
                                            Edit<span class="sr-only">, {{ person.full_name }}</span>
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>