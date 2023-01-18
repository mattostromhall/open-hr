<script setup lang="ts">
import type {ComputedRef} from 'vue'
import {computed} from 'vue'

const props = defineProps<{
    modelValue?: string,
    error?: string,
    inputId?: string,
    inputName?: string,
    rows?: number
}>()

const emit = defineEmits(['update:modelValue', 'reset'])

const rowCount: ComputedRef<number> = computed(() => props.rows ?? 4)

function handleInput(e: Event): void {
    if (props.error) {
        emit('reset')
    }

    emit('update:modelValue', (e.target as HTMLInputElement).value)
}
</script>

<template>
    <div>
        <textarea
            :id="inputId"
            :name="inputName"
            :autocomplete="inputName"
            class="block py-2 px-3 w-full placeholder:text-gray-400 rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm appearance-none sm:text-sm"
            :class="{'border-red-500': error}"
            :rows="rowCount"
            :value="modelValue"
            @input="handleInput"
        />
        <p
            v-if="error"
            class="mt-1 text-sm text-red-500"
        >
            {{ error }}
        </p>
    </div>
</template>