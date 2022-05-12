<script setup lang="ts">
const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false
    }
})

defineEmits(['update:modelValue'])
</script>

<template>
    <button
        type="button"
        class="inline-flex relative shrink-0 w-11 h-6 rounded-full border-2 border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200 ease-in-out cursor-pointer"
        :class="{
            'bg-indigo-600': modelValue,
            'bg-gray-200': !modelValue
        }"
        role="switch"
        :aria-checked="modelValue.toString()"
        @click="$emit('update:modelValue', !props.modelValue)"
    >
        <span class="sr-only">Use setting</span>
        <span
            class="inline-block relative w-5 h-5 bg-white rounded-full ring-0 shadow transition duration-200 ease-in-out translate-x-0 pointer-events-none"
            :class="{
                'translate-x-5': modelValue,
                'translate-x-0': !modelValue
            }"
        >
            <span
                class="flex absolute inset-0 justify-center items-center w-full h-full transition-opacity"
                :class="{
                    'opacity-0 ease-out duration-100': modelValue,
                    'opacity-100 ease-in duration-200': !modelValue
                }"
                aria-hidden="true"
            >
                <svg
                    class="w-3 h-3 text-gray-400"
                    fill="none"
                    viewBox="0 0 12 12"
                >
                    <path
                        d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </span>
            <span
                class="flex absolute inset-0 justify-center items-center w-full h-full transition-opacity"
                :class="{
                    'opacity-100 ease-in duration-200': modelValue,
                    'opacity-0 ease-out duration-100': !modelValue
                }"
                aria-hidden="true"
            >
                <svg
                    class="w-3 h-3 text-indigo-600"
                    fill="currentColor"
                    viewBox="0 0 12 12"
                >
                    <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
                </svg>
            </span>
        </span>
    </button>
</template>