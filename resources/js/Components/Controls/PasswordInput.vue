<script setup lang="ts">
import {EyeIcon, EyeOffIcon} from '@heroicons/vue/24/outline'
import type {Ref} from 'vue'
import {ref} from 'vue'

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
    }
})

const emit = defineEmits(['update:modelValue', 'reset'])

const hidden: Ref<boolean> = ref(true)

function handleInput(e: Event): void {
    if (props.error) {
        emit('reset')
    }

    emit('update:modelValue', (e.target as HTMLInputElement).value)
}
</script>

<template>
    <div class="relative">
        <input
            :id="inputId"
            :name="inputName"
            :type="hidden ? 'password' : 'text'"
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
        <button
            type="button"
            class="absolute top-2 right-2"
            tabindex="-1"
            @click="hidden = !hidden"
        >
            <EyeIcon
                v-if="hidden"
                class="w-5 text-gray-400"
            />
            <EyeOffIcon
                v-else
                class="w-5 text-gray-400"
            />
        </button>
    </div>
</template>