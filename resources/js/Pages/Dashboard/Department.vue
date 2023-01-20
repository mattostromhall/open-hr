<script setup lang="ts">
import {Head} from '@inertiajs/vue3'
import Navigation from './Navigation.vue'
import OrganisationNotifications from './OrganisationNotifications.vue'
import DepartmentQuickLinks from './DepartmentQuickLinks.vue'
import type {Department, Notification} from '../../types'
import DepartmentOverview from './DepartmentOverview.vue'
import {ExclamationTriangleIcon} from '@heroicons/vue/24/outline'

defineProps<{
    department?: Department,
    memberCount?: number,
    head?: string,
    organisationNotifications: (Pick<Notification, 'body'>)[]
}>()
</script>

<template>
    <Head>
        <title>Department Dashboard</title>
    </Head>

    <section class="p-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
            <Navigation />
            <h1 class="sr-only">
                Profile
            </h1>
            <div
                v-if="! department"
                class="bg-white py-6 px-4 mt-6 text-center shadow sm:rounded-md sm:p-6"
            >
                <ExclamationTriangleIcon class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    You are not currently part of a Department
                </h3>
            </div>
            <div
                v-else
                class="mt-6 grid grid-cols-1 items-start gap-4 lg:grid-cols-3 lg:gap-8"
            >
                <div class="grid grid-cols-1 gap-4 lg:col-span-2">
                    <DepartmentOverview
                        :department="department"
                        :member-count="memberCount"
                        :head="head"
                    />
                    <DepartmentQuickLinks :name="department.name" />
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <OrganisationNotifications :notifications="organisationNotifications" />
                </div>
            </div>
        </div>
    </section>
</template>