<script setup lang="ts">
import {Link} from '@inertiajs/inertia-vue3'
import type {Notification} from '../../types'

const props = defineProps<{
    notifications: Notification[]
}>()
</script>

<template>
    <section aria-labelledby="notifications-title">
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="p-6">
                <h2
                    id="notifications-title"
                    class="text-base font-medium text-gray-900"
                >
                    Organisation Notifications
                </h2>
                <div class="flow-root mt-6">
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
                                    {{ notification }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="mt-6">
                    <Link
                        href="/organisation/notifications"
                        class="flex justify-center items-center py-2 px-4 w-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 rounded-md border border-gray-300 shadow-sm"
                    >
                        View all
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>