<script setup lang="ts">
import {Link} from '@inertiajs/inertia-vue3'
import type {Notification} from '../../types'
import useStripHTMLTags from '../../Composables/useStripHTMLTags'

defineProps<{
    notifications: (Pick<Notification, 'body'>)[]
}>()
</script>

<template>
    <section aria-labelledby="notifications-title">
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="p-6">
                <h2
                    id="notifications-title"
                    class="text-base font-medium text-gray-900"
                >
                    Organisation Notifications
                </h2>
                <div class="mt-6 flow-root">
                    <h3
                        v-if="notifications.length === 0"
                        class="text-sm font-medium text-gray-900"
                    >
                        No notifications
                    </h3>
                    <ul
                        v-else
                        role="list"
                        class="-my-5 divide-y divide-gray-200"
                    >
                        <li
                            v-for="notification in notifications"
                            :key="notification"
                            class="py-5"
                        >
                            <div class="relative focus-within:ring-2 focus-within:ring-indigo-500">
                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                    {{ useStripHTMLTags(notification).value }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="mt-6">
                    <Link
                        href="/organisation/notifications"
                        class="flex w-full items-center justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                    >
                        View all
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>