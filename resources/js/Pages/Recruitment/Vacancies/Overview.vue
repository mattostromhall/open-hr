<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import type {Person, Vacancy} from '../../../types'
import {Link} from '@inertiajs/inertia-vue3'
import RedButton from '@/Components/Controls/RedButton.vue'
import {Inertia} from '@inertiajs/inertia'
import SimpleModal from '@/Components/SimpleModal.vue'
import type {Ref} from 'vue'
import {ref} from 'vue'
import {ExclamationTriangleIcon} from '@heroicons/vue/24/outline'
import GreyOutlineButton from '@/Components/Controls/GreyOutlineButton.vue'
import usePermissions from '../../../Hooks/usePermissions'

const props = defineProps<{
    vacancy: Vacancy,
    contact: Pick<Person, 'id' | 'full_name'>
}>()

const {can} = usePermissions()

const showDeleteModal: Ref<boolean> = ref(false)

function deleteVacancy() {
    return Inertia.delete(`/vacancies/${props.vacancy.id}`)
}
</script>

<template>
    <div class="sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0 sm:rounded-md bg-white shadow">
        <div class="flex items-center justify-between py-5 px-4 sm:px-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                Overview
            </h3>
            <RedButton
                v-if="can('delete-vacancy')"
                type="button"
                @click="showDeleteModal = true"
            >
                Delete
            </RedButton>
            <SimpleModal
                v-model="showDeleteModal"
                modal-classes="px-4 pt-5 pb-4 text-left sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
            >
                <form @submit.prevent="deleteVacancy">
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
                                    Are you sure you want to delete the Vacancy? This action cannot be undone.
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
        <div class="px-4 py-5 sm:px-6 border-t border-gray-200">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Title
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ vacancy.title }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Contact
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <Link
                            class="text-indigo-600"
                            :href="`/people/${contact.id}`"
                        >
                            {{ contact.full_name }}
                        </Link>
                    </dd>
                </div>
                <div
                    v-if="vacancy.contract_type"
                    class="sm:col-span-1"
                >
                    <dt class="text-sm font-medium text-gray-500">
                        Contract
                    </dt>
                    <dd class="mt-1 text-sm capitalize text-gray-900">
                        {{ vacancy.contract_type }} <span v-if="vacancy.contract_length">- {{ vacancy.contract_length }}</span>
                    </dd>
                </div>
                <div
                    v-if="vacancy.location"
                    class="sm:col-span-1"
                >
                    <dt class="text-sm font-medium text-gray-500">
                        Location
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ vacancy.location }}
                    </dd>
                </div>
                <div
                    v-if="vacancy.remuneration"
                    class="sm:col-span-1"
                >
                    <dt class="text-sm font-medium text-gray-500">
                        Remuneration
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ vacancy.remuneration }} {{ vacancy.remuneration_currency }}
                    </dd>
                </div>
                <div
                    v-if="vacancy.open_at"
                    class="sm:col-span-1"
                >
                    <dt class="text-sm font-medium text-gray-500">
                        Opens
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ useDateFormat(vacancy.open_at, 'DD/MM/YYYY').value }}
                    </dd>
                </div>
                <div
                    v-if="vacancy.close_at"
                    class="sm:col-span-1"
                >
                    <dt class="text-sm font-medium text-gray-500">
                        Closes
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ useDateFormat(vacancy.close_at, 'DD/MM/YYYY').value }}
                    </dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                        Application Form
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <Link
                            class="text-indigo-600"
                            :href="`/vacancies/${vacancy.public_id}/apply`"
                        >
                            View
                        </Link>
                    </dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">
                        Description
                    </dt>
                    <dd class="mt-1">
                        <div
                            class="prose max-w-none"
                            v-html="vacancy.description"
                        />
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</template>