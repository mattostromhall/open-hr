<script setup lang="ts">
import {computed, ref} from 'vue'
import type {ComputedRef, Ref} from 'vue'
import {TransitionRoot, TransitionChild} from '@headlessui/vue'
import {XIcon} from '@heroicons/vue/outline'
import useNotifications from '../Hooks/useNotifications'
import type {Notification} from '../types'
import NotificationList from '@/Components/NotificationList.vue'
import useNotificationsSlideOver from '../Composables/useNotificationsSlideOver'

type ActiveTab = 'unread'|'read'

const activeTab: Ref<ActiveTab> = ref('unread')

const slideOver = useNotificationsSlideOver()
const notifications = useNotifications()
const unreadNotifications: ComputedRef<Notification[]> = computed(() => notifications.value.filter(notification => ! notification.read))
const readNotifications: ComputedRef<Notification[]> = computed(() => notifications.value.filter(notification => notification.read))

function setActive(tab: ActiveTab): void {
    activeTab.value = tab
}

function isActive(tab: string): boolean {
    return activeTab.value === tab
}
</script>

<template>
    <TransitionRoot
        as="template"
        :show="slideOver.show.value"
    >
        <div
            class="relative z-10"
            aria-labelledby="slide-over-title"
            role="dialog"
            aria-modal="true"
        >
            <div class="overflow-hidden fixed inset-0">
                <div class="overflow-hidden absolute inset-0">
                    <div class="flex fixed inset-y-0 right-0 pl-10 max-w-full pointer-events-none sm:pl-16">
                        <TransitionChild
                            as="template"
                            enter="transform transition ease-in-out duration-500 sm:duration-700"
                            enter-from="translate-x-full"
                            enter-to="translate-x-0"
                            leave="transform transition ease-in-out duration-500 sm:duration-700"
                            leave-from="translate-x-0"
                            leave-to="translate-x-full"
                        >
                            <div class="w-screen max-w-md pointer-events-auto">
                                <div class="flex overflow-y-scroll flex-col h-full bg-white shadow-xl">
                                    <div class="p-6">
                                        <div class="flex justify-between items-start">
                                            <h2
                                                id="slide-over-title"
                                                class="text-lg font-medium text-gray-900"
                                            >
                                                Notifications
                                            </h2>
                                            <div class="flex items-center ml-3 h-7">
                                                <button
                                                    type="button"
                                                    class="text-gray-400 hover:text-gray-500 bg-white rounded-md focus:ring-2 focus:ring-indigo-500"
                                                >
                                                    <span class="sr-only">Close panel</span>
                                                    <XIcon
                                                        class="w-6 h-6"
                                                        @click="slideOver.hideSlideOver"
                                                    />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border-b border-gray-200">
                                        <div class="px-6">
                                            <nav class="flex -mb-px space-x-6">
                                                <button
                                                    class="px-1 pb-4 text-sm font-medium whitespace-nowrap border-b-2"
                                                    :class="{
                                                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': ! isActive('unread'),
                                                        'border-indigo-500 text-indigo-600': isActive('unread')
                                                    }"
                                                    @click="setActive('unread')"
                                                >
                                                    Unread
                                                </button>
                                                <button
                                                    class="px-1 pb-4 text-sm font-medium whitespace-nowrap border-b-2"
                                                    :class="{
                                                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': ! isActive('read'),
                                                        'border-indigo-500 text-indigo-600': isActive('read')
                                                    }"
                                                    @click="setActive('read')"
                                                >
                                                    Read
                                                </button>
                                            </nav>
                                        </div>
                                    </div>
                                    <NotificationList
                                        v-show="isActive('unread')"
                                        :notifications="unreadNotifications"
                                    />
                                    <NotificationList
                                        v-show="isActive('read')"
                                        :notifications="readNotifications"
                                    />
                                </div>
                            </div>
                        </TransitionChild>
                    </div>
                </div>
            </div>
        </div>
    </TransitionRoot>
</template>