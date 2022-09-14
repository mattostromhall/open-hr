<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import {ChatBubbleOvalLeftIcon, CheckCircleIcon, InboxIcon, SparklesIcon, UsersIcon} from '@heroicons/vue/24/outline'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import RequestOneToOne from './OneToOnes/RequestOneToOne.vue'
import ScheduleOneToOne from './OneToOnes/ScheduleOneToOne.vue'
import Upcoming from './OneToOnes/Upcoming.vue'
import Current from './Objectives/Current.vue'
import Create from './Objectives/Create.vue'
import type {Objective, OneToOne, Person, SelectOption} from '../../types'

defineProps<{
    directReports: (Pick<Person, 'id'|'full_name'>)[],
    recurrenceIntervals: SelectOption[],
    manager: Pick<Person, 'id'|'full_name'>,
    oneToOnes: OneToOne[],
    objectives: Objective[]
}>()

type ActiveTab = 'request' | 'schedule' | 'upcoming' | 'current' | 'create'

const activeTab: Ref<ActiveTab> = ref('request')

function setActive(tab: ActiveTab): void {
    activeTab.value = tab
}

function isActive(tab: string): boolean {
    return activeTab.value === tab
}
</script>

<template>
    <Head>
        <title>Performance</title>
    </Head>

    <PageHeading>
        Performance
    </PageHeading>
    <div class="p-8 lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:col-span-3 lg:p-0">
            <nav class="space-y-1">
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('request'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('request')
                    }"
                    aria-current="page"
                    @click="setActive('request')"
                >
                    <UsersIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('request'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('request')
                        }"
                    />
                    <span class="truncate">Request a One-to-one</span>
                </button>
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('schedule'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('schedule')
                    }"
                    aria-current="page"
                    @click="setActive('schedule')"
                >
                    <InboxIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('schedule'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('schedule')
                        }"
                    />
                    <span class="truncate">Schedule One-to-ones</span>
                </button>
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('upcoming'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('upcoming')
                    }"
                    aria-current="page"
                    @click="setActive('upcoming')"
                >
                    <ChatBubbleOvalLeftIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('upcoming'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('upcoming')
                        }"
                    />
                    <span class="truncate">Upcoming One-to-ones</span>
                </button>
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('current'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('current')
                    }"
                    aria-current="page"
                    @click="setActive('current')"
                >
                    <CheckCircleIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('current'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('current')
                        }"
                    />
                    <span class="truncate">Current Objectives</span>
                </button>
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('create'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('create')
                    }"
                    aria-current="page"
                    @click="setActive('create')"
                >
                    <SparklesIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('create'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('create')
                        }"
                    />
                    <span class="truncate">Create an Objective</span>
                </button>
            </nav>
        </aside>
        <RequestOneToOne
            v-if="isActive('request')"
            :manager="manager"
            @set-active="setActive"
        />
        <ScheduleOneToOne
            v-if="isActive('schedule')"
            :direct-reports="directReports"
            :recurrence-intervals="recurrenceIntervals"
            @set-active="setActive"
        />
        <Upcoming
            v-if="isActive('upcoming')"
            :one-to-ones="oneToOnes"
            @set-active="setActive"
        />
        <Current
            v-if="isActive('current')"
            :objectives="objectives"
            @set-active="setActive"
        />
        <Create
            v-if="isActive('create')"
            :direct-reports="directReports"
            @set-active="setActive"
        />
    </div>
</template>