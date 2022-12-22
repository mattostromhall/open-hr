<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import type {Application, Breadcrumb, Document, TimeStamp, Vacancy} from '../../../types'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import {Inertia} from '@inertiajs/inertia'
import DocumentDownloadList from '../../../Components/DocumentDownloadList.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'

const props = defineProps<{
    vacancy: Pick<Vacancy, 'id' | 'title'>,
    status: string,
    application: Application & TimeStamp,
    cv: Document
}>()

const breadcrumbs: Breadcrumb[] = [
    {
        link: '/vacancies?active=open',
        display: 'Vacancies'
    },
    {
        link: `/vacancies/${props.vacancy.id}?active=applications`,
        display: props.vacancy.title
    },
    {
        display: props.application.name
    }
]

function pending() {
    Inertia.post(`/applications/${props.application.id}/pending`)
}

function successful() {
    Inertia.post(`/applications/${props.application.id}/successful`)
}

function unsuccessful() {
    Inertia.post(`/applications/${props.application.id}/unsuccessful`)
}
</script>

<template>
    <Head>
        <title>Manage Vacancies</title>
    </Head>

    <PageHeading>
        Application for Vacancy - {{ vacancy.title }}
        <template #link>
            <LightIndigoLink :href="`/vacancies/${vacancy.id}`">
                View Vacancy
            </LightIndigoLink>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        class="pt-8 px-8"
    />
    <section class="p-8">
        <div class="bg-white shadow sm:w-full sm:max-w-4xl sm:rounded-md">
            <div class="flex items-center justify-between py-5 px-4 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Application Information
                </h3>
                <div class="flex space-x-6">
                    <button
                        v-if="application.status === 3"
                        type="button"
                        class="text-sm text-indigo-600 hover:text-indigo-700"
                        @click="pending"
                    >
                        Mark as pending
                    </button>
                    <button
                        v-if="application.status !== 3"
                        type="button"
                        class="text-sm text-indigo-600 hover:text-indigo-700"
                        @click="unsuccessful"
                    >
                        Mark as unsuccessful
                    </button>
                    <IndigoButton
                        v-if="application.status === 2"
                        type="button"
                        @click="pending"
                    >
                        Mark as pending
                    </IndigoButton>
                    <IndigoButton
                        v-if="application.status !== 2"
                        type="button"
                        @click="successful"
                    >
                        Mark as successful
                    </IndigoButton>
                </div>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Name
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ application.name }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Contact Number
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ application.contact_number }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Contact Email
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ application.contact_email }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Applied on
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ useDateFormat(application.created_at, 'DD/MM/YYYY').value }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Status
                        </dt>
                        <dd
                            class="mt-1 inline-flex rounded-full px-2 text-xs font-semibold capitalize leading-5"
                            :class="{
                                'bg-blue-100 text-blue-800': application.status === 1,
                                'bg-green-100 text-green-800': application.status === 2,
                                'bg-red-100 text-red-800': application.status === 3
                            }"
                        >
                            {{ status }}
                        </dd>
                    </div>
                    <div
                        v-if="application.cover_letter"
                        class="sm:col-span-2"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Cover Letter
                        </dt>
                        <dd class="mt-1">
                            <div
                                class="prose max-w-none"
                                v-html="application.cover_letter"
                            />
                        </dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">
                            Resume / CV
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <DocumentDownloadList :documents="cv" />
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
</template>