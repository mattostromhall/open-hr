<script setup lang="ts">
import type {Notification} from '../../../types'
import {useTimeAgo} from '@vueuse/core'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'

const props = defineProps<{
    announcements: (Notification & {created_at: string})[]
}>()
</script>

<template>
    <Head title="Organisation Announcements" />

    <PageHeading>
        Announcements
        <template #link>
            <LightIndigoLink href="/organisation/announcements/create">
                Create
            </LightIndigoLink>
        </template>
    </PageHeading>

    <section class="p-8">
        <ul
            role="list"
            class="space-y-2 sm:space-y-4"
        >
            <li
                v-for="announcement in announcements"
                :key="announcement.id"
                class="py-6 px-4 bg-white shadow sm:px-6 sm:rounded-lg"
            >
                <div
                    class="sm:flex sm:items-baseline"
                    :class="{
                        'sm:justify-between': announcement.title,
                        'sm:justify-end': ! announcement.title
                    }"
                >
                    <h3
                        v-show="announcement.title"
                        class="text-base font-medium"
                    >
                        {{ announcement.title }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-600 whitespace-nowrap sm:mt-0 sm:ml-3">
                        <time :datetime="announcement.created_at">{{ useTimeAgo(announcement.created_at).value }}</time>
                    </p>
                </div>
                <div class="mt-4 space-y-6 text-sm text-gray-800">
                    <p>{{ announcement.body }}</p>
                    <a
                        v-if="announcement.link"
                        :href="announcement.link"
                        class="inline-flex items-center py-0.5 px-2.5 text-sm font-medium leading-5 text-gray-700 bg-white hover:bg-gray-50 rounded-full border border-gray-300 shadow-sm"
                    >Visit</a>
                </div>
            </li>
        </ul>
    </section>
</template>