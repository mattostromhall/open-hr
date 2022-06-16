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

const activeTab: Ref<string> = ref('request')

function setActive(tab: string): void {
    activeTab.value = tab
}

function isActive(tab: string): boolean {
    return activeTab.value === tab
}
</script>

<template>
    <Head title="Profile" />

    <PageHeading>Holidays</PageHeading>
    <div class="p-8 lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:col-span-3 lg:p-0">
            <nav class="space-y-1">
                <button
                    class="group flex items-center py-2 px-3 w-full text-sm font-medium rounded-md"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('request'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('request')
                    }"
                    aria-current="page"
                    @click="setActive('request')"
                >
                    <ClockIcon
                        class="shrink-0 mr-3 -ml-1 w-6 h-6"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('request'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('request')
                        }"
                    />
                    <span class="truncate">Request Holiday</span>
                </button>
                <button
                    class="group flex items-center py-2 px-3 w-full text-sm font-medium rounded-md"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('approved'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('approved')
                    }"
                    aria-current="page"
                    @click="setActive('approved')"
                >
                    <CheckCircleIcon
                        class="shrink-0 mr-3 -ml-1 w-6 h-6"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('approved'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('approved')
                        }"
                    />
                    <span class="truncate">Approved</span>
                </button>
                <button
                    class="group flex items-center py-2 px-3 w-full text-sm font-medium rounded-md"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('pending'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('pending')
                    }"
                    @click="setActive('pending')"
                >
                    <QuestionMarkCircleIcon
                        class="shrink-0 mr-3 -ml-1 w-6 h-6"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('pending'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('pending')
                        }"
                    />
                    <span class="truncate">Pending</span>
                </button>
                <button
                    class="group flex items-center py-2 px-3 w-full text-sm font-medium rounded-md"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('rejected'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('rejected')
                    }"
                    @click="setActive('rejected')"
                >
                    <XCircleIcon
                        class="shrink-0 mr-3 -ml-1 w-6 h-6"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('rejected'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('rejected')
                        }"
                    />
                    <span class="truncate">Rejected</span>
                </button>
            </nav>
        </aside>
        <RequestHoliday v-if="isActive('request')" />
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