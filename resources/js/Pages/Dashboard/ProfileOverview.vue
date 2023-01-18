<script setup lang="ts">
import {Link} from '@inertiajs/inertia-vue3'
import type {Person} from '../../types'

defineProps<{
    person: Pick<Person, 'id' | 'full_name' | 'initials' | 'position'>,
    holidayRemaining: number,
    sickDaysRemaining: number
}>()
</script>

<template>
    <section aria-labelledby="profile-overview-title">
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <h2
                id="profile-overview-title"
                class="sr-only"
            >
                Profile Overview
            </h2>
            <div class="bg-white p-6">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div class="sm:flex sm:space-x-5">
                        <div class="shrink-0">
                            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-r from-indigo-700 to-indigo-500 font-bold text-indigo-50">
                                <span v-if="person.initials">
                                    {{ person.initials }}
                                </span>
                                <svg
                                    v-else
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-8 w-8"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                            <p class="text-sm font-medium text-gray-600">
                                Welcome back,
                            </p>
                            <p class="text-xl font-bold text-gray-900 sm:text-2xl">
                                {{ person.full_name }}
                            </p>
                            <p class="text-sm font-medium text-gray-600">
                                {{ person.position }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 flex justify-center sm:mt-0">
                        <Link
                            :href="'/people/' + person.id + '/profile'"
                            class="flex items-center justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                        >
                            View profile
                        </Link>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 divide-y divide-gray-200 border-t border-gray-200 bg-gray-50 sm:grid-cols-2 sm:divide-y-0 sm:divide-x">
                <div class="py-5 px-6 text-center text-sm font-medium">
                    <span class="font-semibold text-gray-900">{{ holidayRemaining }}</span>
                    <span class="text-gray-600"> Holiday days remaining</span>
                </div>
                <div class="py-5 px-6 text-center text-sm font-medium">
                    <span class="font-semibold text-gray-900">{{ sickDaysRemaining }}</span>
                    <span class="text-gray-600"> Sick days remaining</span>
                </div>
            </div>
        </div>
    </section>
</template>