<script setup lang="ts">
import {Link} from '@inertiajs/inertia-vue3'
import type {Breadcrumb} from '../types'
import {HomeIcon} from '@heroicons/vue/20/solid'

defineProps<{
    breadcrumbs: Breadcrumb[]
}>()
</script>

<template>
    <nav
        class="flex"
        aria-label="Breadcrumb"
    >
        <ol
            role="list"
            class="flex items-center space-x-4"
        >
            <li>
                <div>
                    <Link
                        href="/dashboard"
                        class="text-gray-400 hover:text-gray-500"
                    >
                        <HomeIcon class="h-5 w-5 shrink-0" />
                        <span class="sr-only">Home</span>
                    </Link>
                </div>
            </li>
            <li
                v-for="breadcrumb in breadcrumbs"
                :key="breadcrumb.display"
            >
                <div class="flex items-center">
                    <svg
                        class="h-5 w-5 shrink-0 text-gray-300"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        aria-hidden="true"
                    >
                        <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                    </svg>
                    <Link
                        v-if="breadcrumb.link"
                        :href="breadcrumb.link"
                        class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"
                    >
                        {{ breadcrumb.display }}
                    </Link>
                    <span
                        v-else
                        class="block ml-4 text-sm font-medium text-gray-500"
                    >
                        {{ breadcrumb.display }}
                    </span>
                </div>
            </li>
        </ol>
    </nav>
</template>