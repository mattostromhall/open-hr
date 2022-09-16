<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import Navigation from './Navigation.vue'
import OrganisationNotifications from './OrganisationNotifications.vue'
import Objectives from './Objectives.vue'
import QuickLinks from './QuickLinks.vue'
import ProfileOverview from './ProfileOverview.vue'
import type {Notification, Objective, Person} from '../../types'

defineProps<{
    person: Pick<Person, 'id' | 'full_name' | 'initials' | 'position'>,
    holidayRemaining: number,
    sickDaysRemaining: number,
    organisationNotifications: (Pick<Notification, 'body'>)[],
    objectives: (Pick<Objective, 'id' | 'title' | 'description'>)[]
}>()
</script>

<template>
    <Head>
        <title>Dashboard</title>
    </Head>

    <section class="p-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
            <Navigation />
            <h1 class="sr-only">
                Profile
            </h1>
            <div class="mt-6 grid grid-cols-1 items-start gap-4 lg:grid-cols-3 lg:gap-8">
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