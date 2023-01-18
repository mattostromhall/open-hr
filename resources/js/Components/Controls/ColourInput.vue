<script setup lang="ts">
const props = defineProps<{
    modelValue?: string,
    error?: string,
    inputId?: string,
    inputName?: string
}>()

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
            type="color"
            class="block px-1 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm appearance-none"
            :class="{'border-red-500': error}"
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