<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import {Head, useForm} from '@inertiajs/vue3'
import type {Breadcrumb, Holiday, HolidayStatus} from '../../../types'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import TextAreaInput from '@/Components/Controls/TextAreaInput.vue'
import PageHeading from '@/Components/PageHeading.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import usePermissions from '../../../Hooks/usePermissions'

const props = defineProps<{
    requester: string,
    holiday: Holiday,
    status: string,
    duration: number
}>()

const {can} = usePermissions()

const breadcrumbs: Breadcrumb[] = [
    {
        link: '/holidays/manage',
        display: 'Manage Holidays'
    },
    {
        display: 'Review Holiday Request'
    },
]

type ReviewHolidayData = {
    notes?: string,
    status: HolidayStatus
}

const start = useDateFormat(props.holiday.start_at, 'DD/MM/YYYY')
const finish = useDateFormat(props.holiday.finish_at, 'DD/MM/YYYY')

const form = useForm<ReviewHolidayData>({
    notes: props.holiday.notes ?? undefined,
    status: props.holiday.status
})

function submit(): void {
    form.patch(`/holidays/${props.holiday.id}/review`)
}

function approve(): void {
    form.status = 2

    submit()
}

function reject(): void {
    form.status = 3

    submit()
}
</script>

<template>
    <Head>
        <title>Review Holiday Request</title>
    </Head>

    <PageHeading>
        Review Holiday Request
        <template #link>
            <LightIndigoLink
                v-if="can('view-holiday-calendar')"
                href="/holidays/calendar"
            >
                View calendar
            </LightIndigoLink>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        dashboard="/dashboard/management"
        class="pt-8 px-8"
    />
    <section class="p-8">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="py-5 px-4 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Holiday requested by {{ requester }}
                </h3>
                <div class="mt-2 max-w-xl text-sm text-gray-500">
                    <p v-if="holiday.half_day">
                        Half day {{ holiday.half_day }} requested on {{ start }}
                    </p>
                    <p v-else>
                        {{ duration }} days requested, starting on {{ start }} and finishing on {{ finish }}
                    </p>
                    <p class="mt-1">
                        Status: {{ status }}
                    </p>
                    <p
                        v-if="holiday.notes"
                        class="mt-1"
                    >
                        Request info: {{ holiday.notes }}
                    </p>
                </div>
                <div class="mt-3">
                    <FormLabel>Notes</FormLabel>
                    <div class="mt-1">
                        <TextAreaInput
                            v-model="form.notes"
                            :error="form.errors.notes"
                            input-id="notes"
                            input-name="notes"
                            @reset="form.clearErrors('notes')"
                        />
                    </div>
                </div>
                <div class="mt-5 flex space-x-5">
                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-green-100 py-2 px-4 font-medium text-green-700 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:text-sm"
                        @click="approve"
                    >
                        Approve
                    </button>
                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-100 py-2 px-4 font-medium text-red-700 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:text-sm"
                        @click="reject"
                    >
                        Reject
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>