<script setup lang="ts">
import {computed, reactive} from 'vue'
import type {ComputedRef} from 'vue'
import type {FileInput, FileType} from '../../types'

const props = defineProps({
    modelValue: File,
    error: {
        type: String,
        default: ''
    },
    inputId: {
        type: String,
        required: true
    },
    inputName: {
        type: String,
        required: true
    },
    types: {
        type: Array as () => FileType[],
        default: () => [
            {value: 'image/png', display: 'png'},
            {value: 'image/jpg', display: 'jpg'},
            {value: 'image/jpeg', display: 'jpeg'},
            {value: 'application/pdf', display: 'pdf'}
        ]
    },
    maxSize: {
        type: Number,
        default: 20971520
    }
})

const emit = defineEmits(['update:modelValue', 'reset'])

const state: FileInput = reactive({
    validExtension: true,
    validSize: true,
    message: ''
})

const allowedTypesDisplay: ComputedRef<string> = computed(() => {
    return props.types
        .map(type => {
            return type.display
        })
        .join(', ')
        .toUpperCase()
})

const allowedTypes: ComputedRef<string[]> = computed(() => {
    return props.types
        .map(type => {
            return type.value
        })
})

const maxSizeInMB: ComputedRef<number> = computed(() => {
    return Math.floor(props.maxSize / 1000000)
})

function resetInput() {
    if (props.error) {
        emit('reset')
    }

    state.validExtension = true
    state.validSize = true
    state.message = ''
}

function getFile({target}: Event): File|undefined {
    const files: FileList|null = (target as HTMLInputElement).files

    if (! files?.length) {
        return
    }

    return files[0]
}

function processFile(event: Event): void {
    resetInput()

    const file = getFile(event)

    if (! file) {
        state.message = 'No file found'
        return
    }

    if (! allowedTypes.value.includes(file.type)) {
        state.validExtension = false
        state.message = 'Invalid file type'
        return
    }

    if (file.size > props.maxSize) {
        state.validSize = false
        state.message = 'File exceeds maximum file size'
        return
    }

    emit('update:modelValue', file)
}
</script>

<template>
    <div class="group flex flex-col justify-center items-center mt-1 w-full cursor-pointer">
        <div
            class="flex relative flex-col w-full h-32 hover:bg-indigo-100 rounded-lg border-2 border-gray-300 hover:border-indigo-600 border-dotted transition ease-in-out"
            :class="{'border-red-500': error}"
        >
            <span class="flex flex-col justify-center items-center p-4 cursor-pointer">
                <svg
                    class="w-12 h-12 text-gray-400 group-hover:text-indigo-600 transition ease-in-out"
                    stroke="currentColor"
                    fill="none"
                    viewBox="0 0 48 48"
                    aria-hidden="true"
                >
                    <path
                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
                <span class="pt-1 text-sm text-indigo-500 group-hover:text-indigo-600 transition ease-in-out">Upload a file</span>
                <span class="text-xs text-gray-500 group-hover:text-indigo-600 transition ease-in-out">
                    {{ allowedTypesDisplay }} up to {{ maxSizeInMB }}MB
                </span>
            </span>
            <input
                :id="inputId"
                :name="inputName"
                type="file"
                class="absolute w-full h-full opacity-0 cursor-pointer"
                @input="processFile"
            >
        </div>
        <p
            v-if="state.message || error"
            class="mt-1 w-full text-sm text-red-500"
        >
            {{ state.message || error }}
        </p>
    </div>
</template>