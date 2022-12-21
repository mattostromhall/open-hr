<script setup lang="ts">
import type {Breadcrumb, Document, Sickness} from '../../../types'
import {useDateFormat} from '@vueuse/core'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import RedButton from '@/Components/Controls/RedButton.vue'
import DocumentDownloadList from '@/Components/DocumentDownloadList.vue'
import {Inertia} from '@inertiajs/inertia'
import SimpleModal from '@/Components/SimpleModal.vue'
import type {Ref} from 'vue'
import {ref} from 'vue'
import {ExclamationTriangleIcon} from '@heroicons/vue/24/outline'
import GreyOutlineButton from '@/Components/Controls/GreyOutlineButton.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'

const props = defineProps<{
    sickness: Sickness,
    logger: string,
    documents?: Document[]
}>()

const breadcrumbs: Breadcrumb[] = [
    {
        link: '/sicknesses',
        display: 'Sick Days'
    },
    {
        display: 'Sick Day'
    }
]

const showDeleteModal: Ref<boolean> = ref(false)

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
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        class="pt-8 px-8"
    />
    <section class="w-full p-8 sm:max-w-6xl">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="flex items-center justify-between py-5 px-4 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Sickness Information
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
                    <form @submit.prevent="deleteSickness">
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
                                        Are you sure you want to delete the Sick day? This action cannot be undone.
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