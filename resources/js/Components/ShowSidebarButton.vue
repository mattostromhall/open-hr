<script setup lang="ts">
import {MenuIcon} from '@heroicons/vue/outline'

defineEmits(['show'])
</script>

<template>
    <div class="sticky top-0 z-10 pt-1 pl-1 bg-gray-100 sm:pt-3 sm:pl-3 md:hidden">
        <button
            type="button"
            class="inline-flex justify-center items-center -mt-0.5 -ml-0.5 w-12 h-12 text-gray-500 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
            @click="$emit('show', true)"
        >
            <span class="sr-only">Open sidebar</span>
            <MenuIcon
                class="w-6 h-6"
                aria-hidden="true"
            />
        </button>
    </div>
</template>