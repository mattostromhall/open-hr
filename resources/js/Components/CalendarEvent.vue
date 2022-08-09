<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import {TransitionRoot, TransitionChild} from '@headlessui/vue'
import {XIcon} from '@heroicons/vue/outline'
import useCalendarSlideOver from '../Composables/useCalendarSlideOver'

const {show, calendarEvent, hideCalendarEvent} = useCalendarSlideOver()
</script>

<template>
    <TransitionRoot
        as="template"
        :show="show"
    >
        <div
            class="relative z-10"
            aria-labelledby="slide-over-title"
            role="dialog"
            aria-modal="true"
        >
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
                <TransitionChild
                    as="template"
                    enter="transform transition ease-in-out duration-500 sm:duration-700"
                    enter-from="translate-x-full"
                    enter-to="translate-x-0"
                    leave="transform transition ease-in-out duration-500 sm:duration-700"
                    leave-from="translate-x-0"
                    leave-to="translate-x-full"
                >
                    <div class="pointer-events-auto w-screen max-w-md">
                        <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <h2
                                        id="slide-over-title"
                                        class="text-lg font-medium text-gray-900"
                                    >
                                        Calendar Event
                                    </h2>
                                    <div class="ml-3 flex h-7 items-center">
                                        <button
                                            type="button"
                                            class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:ring-2 focus:ring-indigo-500"
                                        >
                                            <span class="sr-only">Close panel</span>
                                            <XIcon
                                                class="h-6 w-6"
                                                @click="hideCalendarEvent"
                                            />
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="border-b border-gray-200" />
                            <div class="space-y-6 p-6 pb-16">
                                <div>
                                    <h3 class="font-medium text-gray-900">
                                        Information
                                    </h3>
                                    <dl class="mt-2 divide-y divide-gray-200 border-y border-gray-200">
                                        <div class="flex justify-between py-3 text-sm font-medium">
                                            <dt class="text-gray-500">
                                                Name
                                            </dt>
                                            <dd class="text-gray-900">
                                                {{ calendarEvent.person.full_name }}
                                            </dd>
                                        </div>
                                        <div class="flex justify-between py-3 text-sm font-medium">
                                            <dt class="text-gray-500">
                                                Start at
                                            </dt>
                                            <dd class="text-gray-900">
                                                {{ useDateFormat(calendarEvent.start_at, 'DD/MM/YYYY').value }}
                                            </dd>
                                        </div>
                                        <div
                                            v-show="! calendarEvent.half_day"
                                            class="flex justify-between py-3 text-sm font-medium"
                                        >
                                            <dt class="text-gray-500">
                                                Finish at
                                            </dt>
                                            <dd class="text-gray-900">
                                                {{ useDateFormat(calendarEvent.finish_at, 'DD/MM/YYYY').value }}
                                            </dd>
                                        </div>
                                        <div
                                            v-show="calendarEvent.half_day"
                                            class="flex justify-between py-3 text-sm font-medium"
                                        >
                                            <dt class="text-gray-500">
                                                Half day
                                            </dt>
                                            <dd class="uppercase text-gray-900">
                                                {{ calendarEvent.half_day }}
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                                <div>
                                    <h3 class="mb-1 font-medium text-gray-900">
                                        Status
                                    </h3>
                                    <p
                                        v-if="calendarEvent.status === 1"
                                        class="inline-flex rounded-full bg-blue-100 px-2 text-xs font-semibold leading-5 text-blue-800"
                                    >
                                        Pending
                                    </p>
                                    <p
                                        v-else
                                        class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800"
                                    >
                                        Approved
                                    </p>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-900">
                                        Notes
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm italic text-gray-500">
                                            {{ calendarEvent.notes ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </div>
    </TransitionRoot>
</template>