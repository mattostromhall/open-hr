<script setup lang="ts">
import type {Notification} from '../../../types'
import {useTimeAgo} from '@vueuse/core'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'

const props = defineProps<{
    organisationNotifications: (Notification & {created_at: string})[]
}>()
</script>

<template>
    <Head title="Organisation Notifications" />

    <PageHeading>
        Organisation Notifications
        <template #link>
            <LightIndigoLink href="/organisation/notifications/create">
                Add Notification
            </LightIndigoLink>
        </template>
    </PageHeading>

    <section class="p-8">
        <ul
            role="list"
            class="space-y-2 sm:space-y-4"
        >
            <li
                v-for="notification in organisationNotifications"
                :key="notification.id"
                class="py-6 px-4 bg-white shadow sm:px-6 sm:rounded-lg"
            >
                <div
                    class="sm:flex sm:items-baseline"
                    :class="{
                        'sm:justify-between': notification.title,
                        'sm:justify-end': ! notification.title
                    }"
                >
                    <h3
                        v-show="notification.title"
                        class="text-base font-medium"
                    >
                        {{ notification.title }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-600 whitespace-nowrap sm:mt-0 sm:ml-3">
                        <time :datetime="notification.created_at">{{ useTimeAgo(notification.created_at).value }}</time>
                    </p>
                </div>
                <div class="mt-4 space-y-6 text-sm text-gray-800">
                    <p>{{ notification.body }}</p>
                    <a
                        v-if="notification.link"
                        :href="notification.link"
                        target="_blank"
                        class="inline-flex items-center py-0.5 px-2.5 text-sm font-medium leading-5 text-gray-700 bg-white hover:bg-gray-50 rounded-full border border-gray-300 shadow-sm"
                    >Visit</a>
                </div>
            </li>
        </ul>
    </section>
</template>