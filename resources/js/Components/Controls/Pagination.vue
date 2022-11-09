<script setup lang="ts">
import type {Paginator, PaginatorLink} from '../../types'
import {Link} from '@inertiajs/inertia-vue3'
import {ChevronLeftIcon, ChevronRightIcon} from '@heroicons/vue/20/solid'

const props = defineProps<{
    paginator: Paginator
}>()

const links: PaginatorLink[] = props.paginator.links.slice(1, -1)
</script>

<template>
    <div class="flex items-center justify-between py-6">
        <div
            v-if="links.length > 1"
            class="flex flex-1 justify-between sm:hidden"
        >
            <Link
                v-if="paginator.prev_page_url"
                :href="paginator.prev_page_url"
                class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Previous
            </Link>
            <div
                v-else
                class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-400"
            >
                Previous
            </div>
            <Link
                v-if="paginator.next_page_url"
                :href="paginator.next_page_url"
                class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Next
            </Link>
            <div
                v-else
                class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-400"
            >
                Next
            </div>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ paginator.from }}</span>
                    to
                    <span class="font-medium">{{ paginator.to }}</span>
                    of
                    <span class="font-medium">{{ paginator.total }}</span>
                    results
                </p>
            </div>
            <div v-if="links.length > 1">
                <nav
                    class="isolate inline-flex -space-x-px rounded-md shadow-sm"
                    aria-label="Pagination"
                >
                    <Link
                        v-if="paginator.prev_page_url"
                        :href="paginator.prev_page_url"
                        class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white p-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20"
                    >
                        <span class="sr-only">Previous</span>
                        <ChevronLeftIcon class="h-5 w-5" />
                    </Link>
                    <div
                        v-else
                        class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white p-2 text-sm font-medium text-gray-300"
                    >
                        <span class="sr-only">Previous</span>
                        <ChevronLeftIcon class="h-5 w-5" />
                    </div>
                    <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
                    <Link
                        v-for="link in links"
                        :key="link.url"
                        :href="link.url"
                        aria-current="page"
                        class="relative inline-flex items-center border px-4 py-2 text-sm font-medium focus:z-20"
                        :class="{
                            'z-10 bg-indigo-50 border-indigo-500 text-indigo-600': link.active,
                            'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': ! link.active
                        }"
                    >
                        {{ link.label }}
                    </Link>
                    <Link
                        v-if="paginator.next_page_url"
                        :href="paginator.next_page_url"
                        class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white p-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20"
                    >
                        <span class="sr-only">Next</span>
                        <ChevronRightIcon class="h-5 w-5" />
                    </Link>
                    <div
                        v-else
                        class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white p-2 text-sm font-medium text-gray-300"
                    >
                        <span class="sr-only">Next</span>
                        <ChevronRightIcon class="h-5 w-5" />
                    </div>
                </nav>
            </div>
        </div>
    </div>
</template>