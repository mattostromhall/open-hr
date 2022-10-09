<script setup lang="ts">
import {Link} from '@inertiajs/inertia-vue3'
import type {Objective} from '../../types'
defineProps<{
    objectives: (Pick<Objective, 'id' | 'title' | 'description'>)[]
}>()
</script>

<template>
    <section aria-labelledby="objectives-title">
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="p-6">
                <h2
                    id="objectives-title"
                    class="text-base font-medium text-gray-900"
                >
                    Objectives
                </h2>
                <div class="mt-6 flow-root">
                    <h3
                        v-if="objectives.length === 0"
                        class="text-sm font-medium text-gray-900"
                    >
                        No objectives
                    </h3>
                    <ul
                        v-else
                        role="list"
                        class="-my-5 divide-y divide-gray-200"
                    >
                        <li
                            v-for="{id, title, description} in objectives"
                            :key="id"
                            class="py-4"
                        >
                            <div class="flex items-center space-x-4">
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-gray-900">
                                        {{ title }}
                                    </p>
                                    <p
                                        class="truncate text-sm text-gray-500"
                                        v-html="description"
                                    />
                                </div>
                                <div>
                                    <Link
                                        :href="`/objectives/${id}`"
                                        class="inline-flex items-center rounded-full border border-gray-300 bg-white py-0.5 px-2.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50"
                                    >
                                        View
                                    </Link>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="mt-6">
                    <Link
                        href="/performance"
                        class="flex w-full items-center justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                    >
                        View all
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>