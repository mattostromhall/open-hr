<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import OrganisationNotifications from './OrganisationNotifications.vue'
import OrganisationQuickLinks from './OrganisationQuickLinks.vue'
import OrganisationOverview from './OrganisationOverview.vue'
import type {Organisation} from '../../types'
import Navigation from './Navigation.vue'
import type {Notification} from '../../types'

defineProps<{
    organisation: Organisation,
    logo: string,
    headCount: number,
    departmentCount: number,
    organisationNotifications: (Pick<Notification, 'body'>)[]
}>()
</script>

<template>
    <Head>
        <title>Organisation Dashboard</title>
    </Head>

    <section class="p-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
            <Navigation />
            <h1 class="sr-only">
                Organisation
            </h1>
            <div class="mt-6 grid grid-cols-1 items-start gap-4 lg:grid-cols-3 lg:gap-8">
                <div class="grid grid-cols-1 gap-4 lg:col-span-2">
                    <OrganisationOverview
                        :organisation="organisation"
                        :logo="logo"
                        :head-count="headCount"
                        :department-count="departmentCount"
                    />
                    <OrganisationQuickLinks />
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <OrganisationNotifications :notifications="organisationNotifications" />
                </div>
            </div>
        </div>
    </section>
</template>