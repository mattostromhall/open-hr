<script setup lang="ts">
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import {Head, Link} from '@inertiajs/inertia-vue3'
import type {Breadcrumb, Department, Person} from '../../types'
import type {ComputedRef} from 'vue'
import {computed} from 'vue'
import {Inertia} from '@inertiajs/inertia'
import SimpleModal from '@/Components/SimpleModal.vue'
import type {Ref} from 'vue'
import {ref} from 'vue'
import {ExclamationTriangleIcon} from '@heroicons/vue/24/outline'
import RedButton from '@/Components/Controls/RedButton.vue'
import GreyOutlineButton from '@/Components/Controls/GreyOutlineButton.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import usePermissions from '../../Hooks/usePermissions'

const props = defineProps<{
    department: Department,
    head: Pick<Person, 'id' | 'first_name' | 'last_name' | 'full_name'>,
    members: (Pick<Person, 'id' | 'first_name' | 'last_name' | 'full_name'>)[]
}>()

const {can} = usePermissions()

const breadcrumbs: Breadcrumb[] = [
    {
        link: '/departments',
        display: 'Departments'
    },
    {
        display: 'Department'
    }
]

const size: ComputedRef<number> = computed(() => props.members.length)

const showDeleteModal: Ref<boolean> = ref(false)

function deleteDepartment() {
    return Inertia.delete(`/departments/${props.department.id}`)
}
</script>

<template>
    <Head>
        <title>View Department</title>
    </Head>

    <PageHeading>
        <span class="font-medium">Viewing</span> - {{ department.name }}
        <template #link>
            <div class="flex space-x-2">
                <LightIndigoLink
                    v-if="can('update-department')"
                    :href="`/departments/${department.id}/edit`"
                >
                    Edit
                </LightIndigoLink>
            </div>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        dashboard="/dashboard/organisation"
        class="pt-8 px-8"
    />
    <section class="w-full p-8 sm:max-w-6xl">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="flex items-center justify-between py-5 px-4 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    {{ department.name }}
                </h3>
                <RedButton
                    type="button"
                    @click="showDeleteModal = true"
                >
                    Delete
                </RedButton>
                <SimpleModal
                    v-model="showDeleteModal"
                    modal-classes="px-4 pt-5 pb-4 text-left sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                >
                    <form @submit.prevent="deleteDepartment">
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
                                        Are you sure you want to dissolve the Department? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                            <RedButton class="w-full sm:w-auto sm:ml-3">
                                Confirm
                            </RedButton>
                            <GreyOutlineButton
                                class="w-full sm:w-auto mt-3 sm:mt-0"
                                @click="showDeleteModal = false"
                            >
                                Cancel
                            </GreyOutlineButton>
                        </div>
                    </form>
                </SimpleModal>
            </div>
            <div class="border-t border-gray-200 py-5 px-4 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Head of Department
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ head.full_name }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Size
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ size === 1 ? `${size} member` : `${size} members` }}
                        </dd>
                    </div>
                    <div
                        v-if="members.length > 0"
                        class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Members
                        </dt>
                        <dd class="mt-1 space-x-1 space-y-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <Link
                                v-for="member in members"
                                :key="member.full_name"
                                class="inline-flex rounded-full bg-indigo-100 px-2 text-xs font-semibold leading-5 text-indigo-800 transition ease-in-out hover:bg-indigo-50"
                                :href="`/people/${member.id}`"
                            >
                                {{ member.full_name }}
                            </Link>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
</template>
