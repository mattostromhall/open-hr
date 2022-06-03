<script setup lang="ts">
import {Link} from '@inertiajs/inertia-vue3'

const props = defineProps({
    person: {
        type: Object,
        required: true
    },
    holidayRemaining: {
        type: Number,
        default: 0
    },
    sickDaysRemaining: {
        type: Number,
        default: 0
    }
})
</script>

<template>
    <section aria-labelledby="profile-overview-title">
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <h2
                id="profile-overview-title"
                class="sr-only"
            >
                Profile Overview
            </h2>
            <div class="p-6 bg-white">
                <div class="sm:flex sm:justify-between sm:items-center">
                    <div class="sm:flex sm:space-x-5">
                        <div class="shrink-0">
                            <div class="flex justify-center items-center w-20 h-20 font-bold text-indigo-50 bg-gradient-to-r from-indigo-700 to-indigo-500 rounded-full">
                                <span v-if="person.initials">
                                    {{ person.initials }}
                                </span>
                                <svg
                                    v-else
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-8 h-8"
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
                        <div class="mt-4 text-center sm:pt-1 sm:mt-0 sm:text-left">
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
                    <div class="flex justify-center mt-5 sm:mt-0">
                        <Link
                            :href="'/people/' + person.id + '/profile'"
                            class="flex justify-center items-center py-2 px-4 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 rounded-md border border-gray-300 shadow-sm"
                        >
                            View profile
                        </Link>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 bg-gray-50 border-t border-gray-200 divide-y divide-gray-200 sm:grid-cols-2 sm:divide-y-0 sm:divide-x">
                <div class="py-5 px-6 text-sm font-medium text-center">
                    <span class="font-semibold text-gray-900">{{ holidayRemaining }}</span>
                    <span class="text-gray-600"> Holiday days remaining</span>
                </div>
                <div class="py-5 px-6 text-sm font-medium text-center">
                    <span class="font-semibold text-gray-900">{{ sickDaysRemaining }}</span>
                    <span class="text-gray-600"> Sick days remaining</span>
                </div>
            </div>
        </div>
    </section>
</template>