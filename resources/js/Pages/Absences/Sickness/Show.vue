<script setup lang="ts">
import type {Document, Sickness} from '../../../types'
import {useDateFormat} from '@vueuse/core'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import RedButton from '@/Components/Controls/RedButton.vue'
import DocumentDownloadList from '@/Components/DocumentDownloadList.vue'
import {Inertia} from '@inertiajs/inertia'

const props = defineProps<{
    sickness: Sickness,
    logger: string,
    documents?: Document[]
}>()

function deleteSickness() {
    return Inertia.delete(`/sicknesses/${props.sickness.id}`)
}
</script>

<template>
    <Head>
        <title>View Sickness</title>
    </Head>

    <PageHeading>
        <span class="font-medium">Viewing</span> - Logged Sickness
        <template #link>
            <div class="flex space-x-2">
                <LightIndigoLink href="/sicknesses">
                    All Sick Days
                </LightIndigoLink>
                <LightIndigoLink :href="`/sicknesses/${sickness.id}/edit`">
                    Edit
                </LightIndigoLink>
            </div>
        </template>
    </PageHeading>
    <section class="w-full p-8 sm:max-w-6xl">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="flex items-center justify-between py-5 px-4 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Sickness Information
                </h3>
                <form @submit.prevent="deleteSickness">
                    <RedButton>Delete</RedButton>
                </form>
            </div>
            <div class="border-t border-gray-200 py-5 px-4 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Logged by
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ logger }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Starts at
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ useDateFormat(sickness.start_at, 'DD/MM/YYYY').value }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Finishes at
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ sickness.finish_at ? useDateFormat(sickness.finish_at, 'DD/MM/YYYY').value : '-' }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Notes
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ sickness.notes ?? '-' }}
                        </dd>
                    </div>
                    <div class="items-center py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Documents
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <DocumentDownloadList
                                v-if="documents.length > 0"
                                :documents="documents"
                            />
                            <span v-else>-</span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
</template>