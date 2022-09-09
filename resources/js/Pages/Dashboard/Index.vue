<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import OrganisationNotifications from './OrganisationNotifications.vue'
import Objectives from './Objectives.vue'
import QuickLinks from './QuickLinks.vue'
import ProfileOverview from './ProfileOverview.vue'

defineProps({
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
    },
    organisationNotifications: {
        type: Array,
        default: () => []
    },
    objectives: {
        type: Array,
        default: () => []
    }
})
</script>

<template>
    <Head>
        <title>Dashboard</title>
    </Head>

    <section class="p-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
            <h1 class="sr-only">
                Profile
            </h1>
            <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-3 lg:gap-8">
                <div class="grid grid-cols-1 gap-4 lg:col-span-2">
                    <ProfileOverview
                        :person="person"
                        :holiday-remaining="holidayRemaining"
                        :sick-days-remaining="sickDaysRemaining"
                    />
                    <QuickLinks />
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <OrganisationNotifications :notifications="organisationNotifications" />
                    <Objectives :objectives="objectives" />
                </div>
            </div>
        </div>
    </section>
</template>