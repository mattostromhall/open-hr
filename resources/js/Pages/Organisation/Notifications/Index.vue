<script setup lang="ts">
import type {Breadcrumb, Notification} from '../../../types'
import {useTimeAgo} from '@vueuse/core'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import usePermissions from '../../../Hooks/usePermissions'

defineProps<{
    organisationNotifications: (Notification & {created_at: string})[]
}>()

const {can} = usePermissions()

const breadcrumbs: Breadcrumb[] = [
    {
        display: 'Notifications'
    }
]
</script>

<template>
    <Head>
        <title>Organisation Notifications</title>
    </Head>

    <PageHeading>
        Organisation Notifications
        <template #link>
            <LightIndigoLink
                v-if="can('create-organisation-notification')"
                href="/organisation/notifications/create"
            >
                Add Notification
            </LightIndigoLink>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        dashboard="/dashboard/organisation"
        class="pt-8 px-8"
    />
    <section class="p-8">
        <ul
            role="list"
            class="space-y-2 sm:space-y-4"
        >
            <li
                v-for="notification in organisationNotifications"
                :key="notification.id"
                class="bg-white py-6 px-4 shadow sm:rounded-lg sm:px-6"
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
                    <p class="mt-1 whitespace-nowrap text-sm text-gray-600 sm:mt-0 sm:ml-3">
                        <time :datetime="notification.created_at">{{ useTimeAgo(notification.created_at).value }}</time>
                    </p>
                </div>
                <div class="mt-4 space-y-6 text-sm text-gray-800">
                    <div
                        class="prose"
                        v-html="notification.body"
                    />
                    <a
                        v-if="notification.link"
                        :href="notification.link"
                        target="_blank"
                        class="inline-flex items-center rounded-full border border-gray-300 bg-white py-0.5 px-2.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50"
                    >Visit</a>
                </div>
            </li>
        </ul>
    </section>
</template>