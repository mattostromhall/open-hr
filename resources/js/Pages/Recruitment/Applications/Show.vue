<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import type {Application, Document, TimeStamp, Vacancy} from '../../../types'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import {PaperClipIcon} from '@heroicons/vue/24/outline'

defineProps<{
    vacancy: Pick<Vacancy, 'id' | 'title'>
    application: Application & TimeStamp,
    cv: Document
}>()
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
    <section class="p-8">
        <div class="bg-white shadow sm:w-full sm:max-w-4xl sm:rounded-md">
            <div class="py-5 px-4 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Application Information
                </h3>
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
                            <ul
                                role="list"
                                class="divide-y divide-gray-200 rounded-md border border-gray-200"
                            >
                                <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                    <div class="flex w-0 flex-1 items-center">
                                        <PaperClipIcon class="h-5 w-5 shrink-0 text-gray-400" />
                                        <span class="ml-2 w-0 flex-1 truncate">{{ cv.name }}.{{ cv.extension }}</span>
                                    </div>
                                    <div class="ml-4 shrink-0">
                                        <a
                                            :href="cv.path"
                                            class="font-medium text-indigo-600 hover:text-indigo-500"
                                        >Download</a>
                                    </div>
                                </li>
                            </ul>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
</template>