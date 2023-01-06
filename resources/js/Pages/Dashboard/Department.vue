<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import Navigation from './Navigation.vue'
import OrganisationNotifications from './OrganisationNotifications.vue'
import DepartmentQuickLinks from './DepartmentQuickLinks.vue'
import type {Department, Notification} from '../../types'
import DepartmentOverview from './DepartmentOverview.vue'

defineProps<{
    department: Department,
    memberCount: number,
    head: string,
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
            <div class="mt-6 grid grid-cols-1 items-start gap-4 lg:grid-cols-3 lg:gap-8">
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