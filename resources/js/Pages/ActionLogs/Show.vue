<script setup lang="ts">
import {useTimeAgo} from '@vueuse/core'
import type {ActionLog, Person} from '../../types'
import {PencilIcon, PlusIcon, TrashIcon} from '@heroicons/vue/24/outline'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'

defineProps<{
    actionLogs: (ActionLog & {
        created_at: string,
        person: Pick<Person, 'id' | 'first_name' | 'last_name' | 'full_name'>
    })[]
}>()

function calculateTimeAgo(actionDate: string) {
    const timeAgo = useTimeAgo(new Date(actionDate))

    return timeAgo.value
}
</script>

<template>
    <Head>
        <title>Action Log</title>
    </Head>

    <PageHeading>
        Viewing Action Log
        <template #link>
            <LightIndigoLink href="/organisation/dashboard">
                Dashboard
            </LightIndigoLink>
        </template>
    </PageHeading>

    <section class="p-8">
        <div class="space-y-6 bg-white p-8 shadow sm:w-full sm:max-w-3xl sm:rounded-md lg:col-span-9">
            <div class="flow-root">
                <ul
                    role="list"
                    class="-mb-8"
                >
                    <li
                        v-for="(actionLog, index) in actionLogs"
                        :key="actionLog.id"
                    >
                        <div class="relative pb-8">
                            <span
                                v-if="index < actionLogs.length - 1"
                                class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                aria-hidden="true"
                            />
                            <div class="relative flex space-x-3">
                                <div>
                                    <span
                                        class="flex h-8 w-8 items-center justify-center rounded-full ring-8 ring-white"
                                        :class="{
                                            'bg-green-500': actionLog.action === 'CREATED',
                                            'bg-blue-500': actionLog.action === 'UPDATED',
                                            'bg-red-500': actionLog.action === 'DELETED'
                                        }"
                                    >
                                        <PlusIcon
                                            v-if="actionLog.action === 'CREATED'"
                                            class="h-4 w-4 text-green-50"
                                        />
                                        <PencilIcon
                                            v-if="actionLog.action === 'UPDATED'"
                                            class="h-4 w-4 text-blue-50"
                                        />
                                        <TrashIcon
                                            v-if="actionLog.action === 'DELETED'"
                                            class="h-4 w-4 text-red-50"
                                        />
                                    </span>
                                </div>
                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                    <div>
                                        <p class="text-sm capitalize text-gray-500">
                                            {{ actionLog.action.toLowerCase() }} by {{ actionLog.person.full_name }}
                                        </p>
                                    </div>
                                    <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                        <p>{{ calculateTimeAgo(actionLog.created_at) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</template>