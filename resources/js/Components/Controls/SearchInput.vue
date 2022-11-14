<script setup lang="ts">
import {MagnifyingGlassIcon} from '@heroicons/vue/20/solid'
import {onMounted, ref} from 'vue'
import type {Ref} from 'vue'

const props = defineProps<{
    modelValue?: string
}>()

defineEmits(['update:modelValue'])

const search: Ref<HTMLInputElement | null> = ref(null)

onMounted(() => {
    if (props.modelValue) {
        search.value?.focus()
    }
})
</script>

<template>
    <div class="w-full max-w-lg lg:max-w-xs">
        <label
            for="search"
            class="sr-only"
        >
            Search
        </label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <MagnifyingGlassIcon class="h-5 w-5" />
            </div>
            <input
                id="search"
                ref="search"
                name="search"
                class="block w-full rounded-md border border-gray-300 bg-white py-2 pl-10 pr-3 leading-5 placeholder:text-gray-500 focus:border-indigo-500 focus:placeholder:text-gray-400 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                placeholder="Search"
                type="search"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
            >
        </div>
    </div>
</template>