<script setup lang="ts">
import type {Holiday} from '../../../types'
import {useDateFormat} from '@vueuse/core'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import {computed} from 'vue'

const props = defineProps<{
    holiday: Holiday,
    requester: string
}>()

const statusMap = {
    1: 'pending',
    2: 'approved',
    3: 'rejected'
}

const status = computed(() => statusMap[props.holiday.status])
</script>

<template>
    <Head title="View Holiday" />

    <PageHeading>
        <span class="font-medium">Viewing</span> - Holiday request
        <template #link>
            <LightIndigoLink href="/holidays">
                View all
            </LightIndigoLink>
        </template>
    </PageHeading>
    <section class="p-8 w-full sm:max-w-6xl">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="py-5 px-4 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Holiday Information
                </h3>
            </div>
            <div class="py-5 px-4 border-t border-gray-200 sm:p-0">
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
                            Status
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <p
                                class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full"
                                :class="{
                                    'text-blue-800 bg-blue-100': status === 'pending',
                                    'text-green-800 bg-green-100': status === 'approved',
                                    'text-red-800 bg-red-100': status === 'rejected'
                                }"
                            >
                                {{ status }}
                            </p>
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Starts at
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ useDateFormat(holiday.start_at, 'DD/MM/YYYY').value }}
                        </dd>
                    </div>
                    <div
                        v-if="! holiday.half_day"
                        class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Finishes at
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ useDateFormat(holiday.finish_at, 'DD/MM/YYYY').value }}
                        </dd>
                    </div>
                    <div
                        v-if="holiday.half_day"
                        class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Half day
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 uppercase sm:col-span-2 sm:mt-0">
                            {{ holiday.half_day }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Notes
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ holiday.notes ?? '-' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
</template>