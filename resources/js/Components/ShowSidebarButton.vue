<script setup lang="ts">
import {Bars3Icon} from '@heroicons/vue/24/outline'
import useSidebar from '../Composables/useSidebar'

const {showSidebar} = useSidebar()
</script>

<template>
    <div class="sticky top-0 z-10 bg-gray-100 pt-1 pl-1 sm:pt-3 sm:pl-3 md:hidden">
        <button
            type="button"
            class="-mt-0.5 -ml-0.5 inline-flex h-12 w-12 items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
            @click="showSidebar"
        >
            <span class="sr-only">Open sidebar</span>
            <Bars3Icon
                class="h-6 w-6"
                aria-hidden="true"
            />
        </button>
    </div>
</template>