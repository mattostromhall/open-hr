<script setup lang="ts">
import {Head, Link} from '@inertiajs/vue3'
import {computed, ref, watch} from 'vue'
import type {ComputedRef, Ref} from 'vue'
import type {Breadcrumb, Department, Person, Paginated, Paginator} from '../../types'
import IndigoLink from '@/Components/Controls/IndigoLink.vue'
import PageHeading from '@/Components/PageHeading.vue'
import CheckboxInput from '@/Components/Controls/CheckboxInput.vue'
import {EyeIcon, PencilIcon, PlusIcon, TagIcon} from '@heroicons/vue/24/outline'
import Pagination from '@/Components/Controls/Pagination.vue'
import SearchInput from '@/Components/Controls/SearchInput.vue'
import {router} from '@inertiajs/vue3'
import {debounce, omit} from 'lodash'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import SimpleModal from '@/Components/SimpleModal.vue'
import RedButton from '@/Components/Controls/RedButton.vue'
import GreyOutlineButton from '@/Components/Controls/GreyOutlineButton.vue'
import {ExclamationTriangleIcon} from '@heroicons/vue/24/outline'
import usePermissions from '../../Hooks/usePermissions'

const props = defineProps<{
    search?: string,
    departments: Paginated<(Pick<Department, 'id' | 'name'>
        & {
            members_count: number
        }
        & {
            head: Pick<Person, 'id' | 'first_name' | 'last_name' | 'full_name'>
        }
    )>
}>()

const {can} = usePermissions()

const breadcrumbs: Breadcrumb[] = [
    {
        display: 'Departments'
    }
]

let search: Ref<string | undefined> = ref(props.search)

watch(search, debounce(function (search) {
    router.get('/departments', search
        ? {search}
        : undefined,
    {
        preserveState: true,
        replace: true
    })
}, 200))

const paginator: ComputedRef<Paginator> = computed(() => omit(props.departments, 'data'))

let selected: Ref<number[]> = ref([])

function updateSelected(isSelected: boolean, id: number) {
    if (isSelected) {
        return selected.value.push(id)
    }

    return selected.value = selected.value.filter(item => item !== id)
}

function toggleSelected(select: boolean) {
    if (select) {
        return selected.value = props.departments.data.map(department => department.id)
    }

    return selected.value = []
}

function isSelected(id: number) {
    return selected.value.includes(id)
}

const showDeleteModal: Ref<boolean> = ref(false)

function bulkDelete() {
    router.post('/departments/bulk-delete', {
        departments: selected.value
    }, {
        onSuccess: () => {
            toggleSelected(false)
            showDeleteModal.value = false
        }
    })
}
</script>

<template>
    <Head>
        <title>Departments</title>
    </Head>

    <PageHeading>
        Departments
        <template #link>
            <IndigoLink
                v-if="can('create-department')"
                href="/departments/create"
            >
                Add Department
            </IndigoLink>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        dashboard="/dashboard/organisation"
        class="pt-8 px-8"
    />
    <div class="p-8">
        <SearchInput v-model="search" />
        <div
            v-if="departments.data.length === 0"
            class="mx-auto sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0 mt-8"
        >
            <div
                class="bg-white py-6 px-4 text-center shadow sm:rounded-md sm:p-6"
            >
                <TagIcon class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    No Departments
                </h3>
                <p
                    v-if="can('create-department')"
                    class="mt-1 text-sm text-gray-500"
                >
                    Get started by adding a new Department.
                </p>
                <div
                    v-if="can('create-department')"
                    class="mt-6 flex justify-center"
                >
                    <IndigoLink href="/departments/create">
                        <PlusIcon class="mr-2 -ml-1 h-5 w-5" />
                        Add
                    </IndigoLink>
                </div>
            </div>
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
                                v-if="can('bulk-delete-departments')"
                                type="button"
                                class="inline-flex items-center rounded border border-gray-300 bg-white py-1.5 px-2.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-30"
                                @click="showDeleteModal = true"
                            >
                                Delete all
                                <SimpleModal
                                    v-model="showDeleteModal"
                                    modal-classes="px-4 pt-5 pb-4 text-left sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                                >
                                    <div class="sm:flex sm:items-start">
                                        <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <ExclamationTriangleIcon class="h-6 w-6 text-red-600" />
                                        </div>
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <h3
                                                id="modal-title"
                                                class="text-lg font-medium leading-6 text-gray-900"
                                            >
                                                Confirm Delete
                                            </h3>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">
                                                    Are you sure you want to delete the {{ selected.length }} selected Departments? This action cannot be undone.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                        <RedButton
                                            type="button"
                                            class="w-full sm:w-auto sm:ml-3"
                                            @click="bulkDelete"
                                        >
                                            Confirm
                                        </RedButton>
                                        <GreyOutlineButton
                                            class="w-full sm:w-auto mt-3 sm:mt-0"
                                            @click="showDeleteModal = false"
                                        >
                                            Cancel
                                        </GreyOutlineButton>
                                    </div>
                                </SimpleModal>
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
                                        Head of Department
                                    </th>
                                    <th
                                        scope="col"
                                        class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900"
                                    >
                                        Size
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
                                    v-for="department in departments.data"
                                    :key="department.id"
                                    :class="{'bg-gray-50': isSelected(department.id)}"
                                >
                                    <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                                        <div
                                            v-show="isSelected(department.id)"
                                            class="absolute inset-y-0 left-0 w-0.5 bg-indigo-600"
                                        />

                                        <CheckboxInput
                                            class="absolute top-1/2 left-4 -mt-2"
                                            :model-value="isSelected(department.id)"
                                            @checked="updateSelected($event, department.id)"
                                        />
                                    </td>
                                    <td
                                        class="whitespace-nowrap py-4 pr-3 text-sm font-medium text-gray-900"
                                        :class="{'text-indigo-600': isSelected(department.id)}"
                                    >
                                        {{ department.name }}
                                    </td>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                        <Link
                                            v-if="can('view-person')"
                                            class="text-indigo-600"
                                            :href="`/people/${department.head.id}`"
                                        >
                                            {{ department.head.full_name }}
                                        </Link>
                                        <span v-else>
                                            {{ department.head.full_name }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                        {{ department.members_count }} members
                                    </td>
                                    <td class="flex justify-end whitespace-nowrap py-4 pr-4 pl-3 text-right text-sm font-medium sm:pr-6">
                                        <div class="flex items-center space-x-3">
                                            <Link
                                                v-if="can('view-department')"
                                                :href="`/departments/${department.id}`"
                                                class="text-indigo-600 hover:text-indigo-900"
                                            >
                                                <EyeIcon class="h-4 w-4" /><span class="sr-only">, {{ department.name }}</span>
                                            </Link>
                                            <Link
                                                v-if="can('update-department')"
                                                :href="`/departments/${department.id}/edit`"
                                                class="text-indigo-600 hover:text-indigo-900"
                                            >
                                                <PencilIcon class="h-4 w-4" /><span class="sr-only">, {{ department.name }}</span>
                                            </Link>
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