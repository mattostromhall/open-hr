<script setup lang="ts">
defineProps<{
    modelValue?: boolean,
    inputId?: string,
    inputName?: string
}>()

const emit = defineEmits(['update:modelValue', 'checked'])

function emitEvents({target}: Event) {
    const checkbox = (target as HTMLInputElement)

    emit('update:modelValue', checkbox.checked)
    emit('checked', checkbox.checked)
}
</script>

<template>
    <input
        :id="inputId"
        :name="inputName"
        type="checkbox"
        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 sm:left-6"
        :value="modelValue"
        :checked="modelValue"
        @input="emitEvents"
    >
</template>