<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import type {Vacancy} from '../../../types'

defineProps<{
    vacancy: Vacancy,
    contact: {
        name: string,
        email: string
    }
}>()
</script>

<template>
    <div class="w-full max-w-4xl overflow-hidden bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h2 class="text-lg font-medium leading-6 text-gray-900">
                Vacancy Information
            </h2>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
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
                        <a
                            class="text-indigo-600"
                            :href="`mailto:${contact.email}`"
                        >{{ contact.name }} - {{ contact.email }}</a>
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