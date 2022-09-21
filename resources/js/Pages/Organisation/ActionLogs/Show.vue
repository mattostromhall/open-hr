<script setup lang="ts">
import type {ActionLog, Person} from '../../../types'
import {PencilIcon, PlusIcon, TrashIcon} from '@heroicons/vue/24/outline'

defineProps<{
    actionLogs: (ActionLog & {
        person: Pick<Person, 'id' | 'first_name' | 'last_name' | 'full_name'>
    })[]
}>()
</script>

<template>
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
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-400 ring-8 ring-white">
                                        <PencilIcon
                                            v-if="actionLog.action === 'UPDATED'"
                                            class="h-5 w-5 text-white"
                                        />
                                        <PlusIcon
                                            v-if="actionLog.action === 'CREATED'"
                                            class="h-5 w-5 text-white"
                                        />
                                        <TrashIcon
                                            v-if="actionLog.action === 'DELETED'"
                                            class="h-5 w-5 text-white"
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
                                        <time datetime="2020-09-20">Sep 20</time>
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