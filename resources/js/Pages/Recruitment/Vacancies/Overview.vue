<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import type {Person, Vacancy} from '../../../types'
import {Link} from '@inertiajs/inertia-vue3'

defineProps<{
    vacancy: Vacancy,
    contact: Pick<Person, 'id' | 'full_name'>
}>()
</script>

<template>
    <div class="sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0">
        <div class="bg-white px-4 py-5 shadow sm:rounded-md sm:px-6">
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
                <div
                    v-if="vacancy.close_at"
                    class="sm:col-span-1"
                >
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