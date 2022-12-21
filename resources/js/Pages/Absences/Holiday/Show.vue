<script setup lang="ts">
import type {Breadcrumb, Holiday} from '../../../types'
import {useDateFormat} from '@vueuse/core'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import RedButton from '@/Components/Controls/RedButton.vue'
import {computed} from 'vue'
import {Inertia} from '@inertiajs/inertia'
import SimpleModal from '@/Components/SimpleModal.vue'
import type {Ref} from 'vue'
import {ref} from 'vue'
import {ExclamationTriangleIcon} from '@heroicons/vue/24/outline'
import GreyOutlineButton from '@/Components/Controls/GreyOutlineButton.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'

const props = defineProps<{
    holiday: Holiday,
    requester: string
}>()

const breadcrumbs: Breadcrumb[] = [
    {
        link: '/holidays',
        display: 'Holidays'
    },
    {
        display: 'Holiday Request'
    }
]

const statusMap = {
    1: 'pending',
    2: 'approved',
    3: 'rejected'
}

const status = computed(() => statusMap[props.holiday.status])

const showDeleteModal: Ref<boolean> = ref(false)

function deleteHoliday() {
    return Inertia.delete(`/holidays/${props.holiday.id}`)
}
</script>

<template>
    <Head>
        <title>View Holiday</title>
    </Head>

    <PageHeading>
        <span class="font-medium">Viewing</span> - Holiday request
        <template #link>
            <LightIndigoLink :href="`/holidays/${holiday.id}/edit`">
                Edit
            </LightIndigoLink>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        class="pt-8 px-8"
    />
    <section class="w-full p-8 sm:max-w-6xl">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="flex items-center justify-between py-5 px-4 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Holiday Information
                </h3>
                <RedButton
                    type="button"
                    @click="showDeleteModal = true"
                >
                    Cancel
                </RedButton>
                <SimpleModal
                    v-model="showDeleteModal"
                    modal-classes="px-4 pt-5 pb-4 text-left sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                >
                    <form @submit.prevent="deleteHoliday">
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
                                        Are you sure you want to cancel the Holiday Request? This action cannot be undone.
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
                                class="inline-flex rounded-full px-2 text-xs font-semibold leading-5"
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
                        <dd class="mt-1 text-sm uppercase text-gray-900 sm:col-span-2 sm:mt-0">
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