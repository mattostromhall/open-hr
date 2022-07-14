<script setup lang="ts">
import type {Notification} from '../../types'

const props = defineProps<{
    announcements: Notification[]
}>()
</script>

<template>
    <section class="p-8">
        <ul
            role="list"
            class="py-4 space-y-2 sm:px-6 sm:space-y-4 lg:px-8"
        >
            <li class="py-6 px-4 bg-white shadow sm:px-6 sm:rounded-lg">
                <div class="sm:flex sm:justify-between sm:items-baseline">
                    <h3 class="text-base font-medium">
                        <span class="text-gray-900">Joe Armstrong</span>
                        <span class="text-gray-600">wrote</span>
                    </h3>
                    <p class="mt-1 text-sm text-gray-600 whitespace-nowrap sm:mt-0 sm:ml-3">
                        <time datetime="2021-01-28T19:24">Yesterday at 7:24am</time>
                    </p>
                </div>
                <div class="mt-4 space-y-6 text-sm text-gray-800">
                    <p>Thanks so much! Can't wait to try it out.</p>
                </div>
            </li>
        </ul>
    </section>
</template>