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
            :id="props.inputId"
            :name="props.inputName"
            type="number"
            :autocomplete="props.inputName"
            class="block py-2 px-3 w-full placeholder:text-gray-400 rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm appearance-none sm:text-sm"
            :class="{'border-red-500': props.error}"
            :value="props.modelValue"
            @input="handleInput"
        >
        <p
            v-if="props.error"
            class="mt-1 text-sm text-red-500"
        >
            {{ props.error }}
        </p>
    </div>
</template>