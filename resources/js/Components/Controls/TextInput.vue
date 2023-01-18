<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'

const props = defineProps<{
    modelValue?: string,
    error?: string,
    inputId?: string,
    inputName?: string
}>()

const emit = defineEmits(['update:modelValue', 'reset'])

const input: Ref<HTMLInputElement | null> = ref(null)

function handleInput(e: Event): void {
    if (props.error) {
        emit('reset')
    }

    emit('update:modelValue', (e.target as HTMLInputElement).value)
}

defineExpose({input})
</script>

<template>
    <div>
        <input
            :id="inputId"
            ref="input"
            :name="inputName"
            type="text"
            :autocomplete="inputName"
            class="block w-full appearance-none rounded-md border border-gray-300 py-2 px-3 shadow-sm placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
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