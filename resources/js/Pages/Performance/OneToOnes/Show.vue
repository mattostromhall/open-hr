<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import type {OneToOne} from '../../../types'

const props = defineProps<{
    oneToOne: OneToOne,
    requester: string,
    personName: string,
    managerName: string,
    personStatus: string,
    managerStatus: string
}>()
</script>

<template>
    <Head title="View One-to-one" />

    <PageHeading>
        <span class="font-medium">Viewing</span> - One-to-one
        <template #link>
            <LightIndigoLink :href="`/one-to-ones/${oneToOne.id}/edit`">
                Edit
            </LightIndigoLink>
        </template>
    </PageHeading>
    <section class="w-full p-8 sm:max-w-6xl">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="py-5 px-4 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    One-to-one Information
                </h3>
            </div>
            <div class="border-t border-gray-200 py-5 px-4 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Requested by
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ requester }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            {{ personName }}
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <p
                                class="inline-flex rounded-full px-2 text-xs font-semibold capitalize leading-5"
                                :class="{
                                    'text-blue-800 bg-blue-100': personStatus === 'invited',
                                    'text-green-800 bg-green-100': personStatus === 'accepted',
                                    'text-red-800 bg-red-100': personStatus === 'declined'
                                }"
                            >
                                {{ personStatus }}
                            </p>
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            {{ managerName }}
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <p
                                class="inline-flex rounded-full px-2 text-xs font-semibold capitalize leading-5"
                                :class="{
                                    'text-blue-800 bg-blue-100': managerStatus === 'invited',
                                    'text-green-800 bg-green-100': managerStatus === 'accepted',
                                    'text-red-800 bg-red-100': managerStatus === 'declined'
                                }"
                            >
                                {{ managerStatus }}
                            </p>
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Scheduled at
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ useDateFormat(oneToOne.scheduled_at, 'DD/MM/YYYY HH:mm').value }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Completed at
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ oneToOne.completed_at ? useDateFormat(oneToOne.completed_at, 'DD/MM/YYYY HH:mm').value : '-' }}
                        </dd>
                    </div>
                    <div
                        v-if="oneToOne.recurring"
                        class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Recurring
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ oneToOne.recurrence_interval }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Notes
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ oneToOne.notes ?? '-' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
</template>