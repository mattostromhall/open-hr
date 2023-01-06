<script setup lang="ts">
import type {Department} from '../../types'
import {Link} from '@inertiajs/inertia-vue3'

defineProps<{
    department: Department,
    memberCount: number,
    head: string
}>()
</script>

<template>
    <section aria-labelledby="profile-overview-title">
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <h2
                id="profile-overview-title"
                class="sr-only"
            >
                Department Overview
            </h2>
            <div class="bg-white p-6">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div class="sm:flex sm:space-x-5">
                        <div class="shrink-0">
                            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-r from-indigo-700 to-indigo-500 font-bold text-indigo-50">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-8 w-8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 6h.008v.008H6V6z"
                                    />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                            <p class="text-sm font-medium text-gray-600">
                                Welcome to,
                            </p>
                            <p class="text-xl font-bold text-gray-900 sm:text-2xl">
                                {{ department.name }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 flex justify-center sm:mt-0">
                        <Link
                            href="/people/create"
                            class="flex items-center justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                        >
                            Add Member
                        </Link>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 divide-y divide-gray-200 border-t border-gray-200 bg-gray-50 sm:grid-cols-2 sm:divide-y-0 sm:divide-x">
                <div class="py-5 px-6 text-center text-sm font-medium">
                    <span class="font-semibold text-gray-900">{{ memberCount }}</span>
                    <span class="text-gray-600"> People</span>
                </div>
                <div class="py-5 px-6 text-center text-sm font-medium">
                    <span class="font-semibold text-gray-900">{{ head }}</span>
                    <span class="text-gray-600"> (Head)</span>
                </div>
            </div>
        </div>
    </section>
</template>