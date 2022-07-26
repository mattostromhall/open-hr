<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import {CheckCircleIcon, ClockIcon, QuestionMarkCircleIcon, XCircleIcon} from '@heroicons/vue/outline'
import {Head} from '@inertiajs/inertia-vue3'
import RequestHoliday from './RequestHoliday.vue'
import PageHeading from '@/Components/PageHeading.vue'
import Approved from './Approved.vue'
import Pending from './Pending.vue'
import Rejected from './Rejected.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'

defineProps({
    approved: {
        type: Array,
        default: () => []
    },
    pending: {
        type: Array,
        default: () => []
    },
    rejected: {
        type: Array,
        default: () => []
    }
})

type ActiveTab = 'request' | 'approved' | 'pending' | 'rejected'

const activeTab: Ref<ActiveTab> = ref('request')

function setActive(tab: ActiveTab): void {
    activeTab.value = tab
}

function isActive(tab: string): boolean {
    return activeTab.value === tab
}
</script>

<template>
    <Head title="Manage Holiday" />

    <PageHeading>
        Holidays
        <template #link>
            <LightIndigoLink href="/holidays/calendar">
                View calendar
            </LightIndigoLink>
        </template>
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
                    <ClockIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('request'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('request')
                        }"
                    />
                    <span class="truncate">Request Holiday</span>
                </button>
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('approved'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('approved')
                    }"
                    aria-current="page"
                    @click="setActive('approved')"
                >
                    <CheckCircleIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('approved'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('approved')
                        }"
                    />
                    <span class="truncate">Approved</span>
                </button>
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('pending'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('pending')
                    }"
                    @click="setActive('pending')"
                >
                    <QuestionMarkCircleIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('pending'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('pending')
                        }"
                    />
                    <span class="truncate">Pending</span>
                </button>
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('rejected'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('rejected')
                    }"
                    @click="setActive('rejected')"
                >
                    <XCircleIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('rejected'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('rejected')
                        }"
                    />
                    <span class="truncate">Rejected</span>
                </button>
            </nav>
        </aside>
        <RequestHoliday
            v-if="isActive('request')"
            @set-active="setActive"
        />
        <Approved
            v-if="isActive('approved')"
            :approved="approved"
        />
        <Pending
            v-if="isActive('pending')"
            :pending="pending"
        />
        <Rejected
            v-if="isActive('rejected')"
            :rejected="rejected"
        />
    </div>
</template>