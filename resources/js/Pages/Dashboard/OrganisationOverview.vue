<script setup lang="ts">
import type {Organisation} from '../../types'
import {Link} from '@inertiajs/vue3'

defineProps<{
    organisation: Organisation,
    logo: string,
    headCount: number,
    departmentCount: number
}>()
</script>

<template>
    <section aria-labelledby="profile-overview-title">
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <h2
                id="profile-overview-title"
                class="sr-only"
            >
                Organisation Overview
            </h2>
            <div class="bg-white p-6">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div class="sm:flex sm:space-x-5">
                        <div class="shrink-0">
                            <img
                                class="h-20 w-20 rounded-full"
                                :src="logo"
                                alt="organisation.name"
                            >
                        </div>
                        <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                            <p class="text-sm font-medium text-gray-600">
                                Welcome to,
                            </p>
                            <p class="text-xl font-bold text-gray-900 sm:text-2xl">
                                {{ organisation.name }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 flex justify-center sm:mt-0">
                        <Link
                            href="/departments/create"
                            class="flex items-center justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                        >
                            Add Department
                        </Link>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 divide-y divide-gray-200 border-t border-gray-200 bg-gray-50 sm:grid-cols-2 sm:divide-y-0 sm:divide-x">
                <div class="py-5 px-6 text-center text-sm font-medium">
                    <span class="font-semibold text-gray-900">{{ headCount }}</span>
                    <span class="text-gray-600"> People</span>
                </div>
                <div class="py-5 px-6 text-center text-sm font-medium">
                    <span class="font-semibold text-gray-900">{{ departmentCount }}</span>
                    <span class="text-gray-600">{{ departmentCount === 1 ? ' Department' : ' Departments' }}</span>
                </div>
            </div>
        </div>
    </section>
</template>