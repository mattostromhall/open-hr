<script setup lang="ts">
const props = defineProps({
    modelValue: {
        type: Number,
        default: 0
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
    step: {
        type: Number,
        default: 1
    }
})

const emit = defineEmits(['update:modelValue', 'reset'])

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
            :step="step"
            :value="modelValue"
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