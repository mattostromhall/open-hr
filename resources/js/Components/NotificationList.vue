<script setup lang="ts">
import {Link} from '@inertiajs/inertia-vue3'
import {ChevronRightIcon} from '@heroicons/vue/solid'

defineProps({
    notifications: {
        type: Array,
        default: () => []
    }
})
</script>

<template>
    <ul
        role="list"
        class="overflow-y-auto flex-1 divide-y divide-gray-200"
    >
        <li
            v-for="notification in notifications"
            :key="notification.body"
        >
            <Link
                v-if="notification.link"
                :href="notification.link"
                class="block hover:bg-gray-50"
            >
                <div class="flex items-center p-4 sm:px-6">
                    <p class="mt-1 text-sm text-gray-600">
                        {{ notification.body }}
                        <Link
                            v-if="! notification.read"
                            :href="`/notifications/${notification.id}/read`"
                            method="post"
                            as="button"
                            type="button"
                            class="block mt-1 text-sm text-indigo-500"
                            preserve-scroll
                            preserve-state
                        >
                            Mark as read
                        </Link>
                    </p>
                    <div>
                        <ChevronRightIcon class="w-5 h-5 text-gray-400" />
                    </div>
                </div>
            </Link>
            <p
                v-else
                class="p-4 mt-1 text-sm text-gray-600 sm:px-6"
            >
                {{ notification.body }}
                <Link
                    v-if="! notification.read"
                    :href="`/notifications/${notification.id}/read`"
                    method="post"
                    as="button"
                    type="button"
                    class="block mt-1 text-sm text-indigo-500"
                    preserve-scroll
                    preserve-state
                >
                    Mark as read
                </Link>
            </p>
        </li>
    </ul>
</template>