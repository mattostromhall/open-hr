<script setup lang="ts">
import type {SelectOption} from '../../types'
import {computed, defineProps} from 'vue'
import type {ComputedRef} from 'vue'

const props = defineProps<{
    modelValue?: string|number,
    inputId: string,
    inputName: string,
    options: SelectOption[],
    error?: string,
    placeholder?: string
}>()

const emit = defineEmits(['update:modelValue', 'reset'])

const placeholder: ComputedRef<string> = computed(() => props.placeholder ?? 'Please select...')

function value(option: SelectOption): string|number {
    return typeof option === 'string' || typeof option === 'number'
        ? option
        : option.value
}

function display(option: SelectOption): string|number {
    return typeof option === 'string' || typeof option === 'number'
        ? option
        : option.display
}

function handleInput(e: Event): void {
    if (props.error) {
        emit('reset')
    }

    emit('update:modelValue', (e.target as HTMLInputElement).value)
}
</script>

<template>
    <div>
        <select
            :id="inputId"
            :name="inputName"
            :autocomplete="inputName"
            class="block py-2 px-3 mt-1 w-full bg-white rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm sm:text-sm"
            :class="{'border-red-500': error}"
            @change="handleInput"
        >
            <option
                value=""
                selected
            >
                {{ placeholder }}
            </option>
            <option
                v-for="option in options"
                :key="option"
                :value="value(option)"
                :selected="value(option) === modelValue"
            >
                {{ display(option) }}
            </option>
        </select>
        <p
            v-if="error"
            class="mt-1 text-sm text-red-500"
        >
            {{ error }}
        </p>
    </div>
</template>