<script setup lang="ts">
import type {ComplexSelectOption} from '../../types'

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    error: {
        type: String,
        default: ''
    },
    inputId: {
        type: String,
        default: ''
    },
    inputName: {
        type: String,
        default: ''
    },
    options: {
        type: Array,
        default: () => []
    },
    placeholder: {
        type: Boolean,
        default: true
    },
    placeholderValue: {
        type: String,
        default: 'Please select'
    }
})

const emit = defineEmits(['update:modelValue', 'reset'])

type SelectOption = string|number|ComplexSelectOption

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
            :id="props.inputId"
            :name="props.inputName"
            :autocomplete="props.inputName"
            class="block py-2 px-3 mt-1 w-full bg-white rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm sm:text-sm"
            :class="{'border-red-500': props.error}"
            @change="handleInput"
        >
            <option
                v-if="placeholder"
                value=""
                selected
            >
                {{ placeholderValue }}
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
            v-if="props.error"
            class="mt-1 text-sm text-red-500"
        >
            {{ props.error }}
        </p>
    </div>
</template>