<script setup lang="ts">
import type {ComputedRef} from 'vue'
import {computed} from 'vue'

const props = defineProps<{
    modelValue?: number,
    error?: string,
    inputId?: string,
    inputName?: string,
    step?: number
}>()

const emit = defineEmits(['update:modelValue', 'reset'])

const value: ComputedRef<number> = computed(() => props.modelValue ?? 0)
const stepBy: ComputedRef<number> = computed(() => props.step ?? 1)

function handleInput(e: Event): void {
    if (props.error) {
        emit('reset')
    }

    emit('update:modelValue', (e.target as HTMLInputElement).value)
}
</script>

<template>
    <div>
        <input
            :id="inputId"
            :name="inputName"
            type="number"
            :autocomplete="inputName"
            class="block w-full appearance-none rounded-md border border-gray-300 py-2 px-3 shadow-sm placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
            :class="{'border-red-500': error}"
            :step="stepBy"
            :value="value"
            @input="handleInput"
        >
        <p
            v-if="error"
            class="mt-1 text-sm text-red-500"
        >
            {{ error }}
        </p>
    </div>
</template>