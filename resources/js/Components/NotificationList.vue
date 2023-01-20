<script setup lang="ts">
import {Link} from '@inertiajs/vue3'
import {ChevronRightIcon} from '@heroicons/vue/24/solid'
import useNotificationsSlideOver from '../Composables/useNotificationsSlideOver'
import type {Notification} from '../types'

defineProps<{
    notifications: Notification[]
}>()

const {hideNotifications} = useNotificationsSlideOver()
</script>

<template>
    <ul
        role="list"
        class="flex-1 divide-y divide-gray-200 overflow-y-auto"
    >
        <li
            v-for="notification in notifications"
            :key="notification.body"
        >
            <div
                v-if="notification.link"
                class="group"
            >
                <Link
                    :href="notification.link"
                    class="block group-hover:bg-gray-50"
                    @click="hideNotifications"
                >
                    <div class="flex items-center justify-between space-x-2 px-4 pt-4 sm:px-6">
                        <div>
                            <h3
                                v-show="notification.title"
                                class="text-sm font-semibold text-gray-800"
                            >
                                {{ notification.title }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ notification.body }}
                            </p>
                        </div>
                        <div>
                            <ChevronRightIcon class="h-5 w-5 text-gray-400" />
                        </div>
                    </div>
                </Link>
                <p class="px-4 pt-1 pb-4 text-sm text-gray-600 group-hover:bg-gray-50 sm:px-6">
                    <Link
                        :href="`/notifications/${notification.id}/read`"
                        :data="{read: ! notification.read}"
                        method="post"
                        as="button"
                        type="button"
                        class="mt-1 block text-sm text-indigo-500"
                        preserve-scroll
                        preserve-state
                    >
                        {{ notification.read ? 'Mark as unread' : 'Mark as read' }}
                    </Link>
                </p>
            </div>
            <div
                v-else
                class="p-4 sm:px-6"
            >
                <h3
                    v-show="notification.title"
                    class="text-sm font-semibold text-gray-800"
                >
                    {{ notification.title }}
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                    {{ notification.body }}
                    <Link
                        :href="`/notifications/${notification.id}/read`"
                        :data="{read: ! notification.read}"
                        method="post"
                        as="button"
                        type="button"
                        class="mt-1 block text-sm text-indigo-500"
                        preserve-scroll
                        preserve-state
                    >
                        {{ notification.read ? 'Mark as unread' : 'Mark as read' }}
                    </Link>
                </p>
            </div>
        </li>
    </ul>
</template>