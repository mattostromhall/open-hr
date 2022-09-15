<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import type {Training} from '../../../types'
import {AcademicCapIcon, BookmarkIcon, BookmarkSlashIcon, ClockIcon, TrophyIcon} from '@heroicons/vue/24/outline'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import RequestTraining from './RequestTraining.vue'
import Started from './Started.vue'
import NotStarted from './NotStarted.vue'
import Completed from './Completed.vue'
import AwaitingApproval from './AwaitingApproval.vue'

defineProps<{
    started: Training[],
    notStarted: Training[],
    completed: Training[],
    awaitingApproval: Training[]
}>()

type ActiveTab = 'request' | 'started' | 'not-started' | 'completed' | 'awaiting'

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
        <title>Training</title>
    </Head>

    <PageHeading>
        Training
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
                    <AcademicCapIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('request'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('request')
                        }"
                    />
                    <span class="truncate">Request Training</span>
                </button>
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('not-started'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('not-started')
                    }"
                    aria-current="page"
                    @click="setActive('not-started')"
                >
                    <BookmarkSlashIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('not-started'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('not-started')
                        }"
                    />
                    <span class="truncate">Not Started</span>
                </button>
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('started'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('started')
                    }"
                    aria-current="page"
                    @click="setActive('started')"
                >
                    <BookmarkIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('started'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('started')
                        }"
                    />
                    <span class="truncate">Started</span>
                </button>
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('completed'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('completed')
                    }"
                    aria-current="page"
                    @click="setActive('completed')"
                >
                    <TrophyIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('completed'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('completed')
                        }"
                    />
                    <span class="truncate">Completed</span>
                </button>
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('awaiting'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('awaiting')
                    }"
                    aria-current="page"
                    @click="setActive('awaiting')"
                >
                    <ClockIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('awaiting'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('awaiting')
                        }"
                    />
                    <span class="truncate">Awaiting Approval</span>
                </button>
            </nav>
        </aside>
        <RequestTraining
            v-if="isActive('request')"
            @set-active="setActive"
        />
        <NotStarted
            v-if="isActive('not-started')"
            :not-started="notStarted"
            @set-active="setActive"
        />
        <Started
            v-if="isActive('started')"
            :started="started"
            @set-active="setActive"
        />
        <Completed
            v-if="isActive('completed')"
            :completed="completed"
            @set-active="setActive"
        />
        <AwaitingApproval
            v-if="isActive('awaiting')"
            :awaiting-approval="awaitingApproval"
            @set-active="setActive"
        />
    </div>
</template>