<script setup lang="ts">
defineProps({
    modelValue: {
        type: Boolean,
        default: false
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
        class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500 sm:left-6"
        :value="modelValue"
        :checked="modelValue"
        @input="emitEvents"
    >
</template>