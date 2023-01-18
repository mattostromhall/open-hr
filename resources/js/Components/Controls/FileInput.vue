<script setup lang="ts">
import {computed, reactive, ref} from 'vue'
import type {ComputedRef, Ref} from 'vue'
import type {FileInput} from '../../types'

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
        type: Array,
        default: () => ['png', 'jpg', 'jpeg', 'pdf', 'docx']
    },
    maxSize: {
        type: Number,
        default: 20971520
    },
    multiple: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['update:modelValue', 'reset'])

const state: FileInput = reactive({
    validSize: true,
    dragActive: false,
    message: ''
})


const allowedTypes: ComputedRef<string> = computed(() => {
    return props.types
        .join(', ')
        .toUpperCase()
})

const maxSizeInMB: ComputedRef<number> = computed(() => {
    return Math.floor(props.maxSize / 1000000)
})

function resetInput() {
    if (props.error) {
        emit('reset')
    }

    state.validSize = true
    state.message = ''
}

function setDragActive() {
    state.dragActive = true
}
function setDragInactive() {
    state.dragActive = false
}

function onDrop(event: DragEvent) {
    setDragInactive()

    processUpload(event)
}

function getFiles(event: Event | DragEvent): File | File[] | undefined {
    const files: FileList | undefined | null = event instanceof DragEvent
        ? event.dataTransfer?.files
        : (event.target as HTMLInputElement).files

    if (! files?.length) {
        return
    }

    return props.multiple
        ? [...files]
        : files[0]
}

function processUpload(event: Event | DragEvent): void {
    resetInput()

    const files = getFiles(event)

    if (! files) {
        state.message = 'No files found'
        return
    }

    if (Array.isArray(files)) {
        processFiles(files)
    }

    if (files instanceof File) {
        processFile(files)
    }
}

function processFile(file: File) {
    if (file.size > props.maxSize) {
        state.validSize = false
        state.message = 'File exceeds maximum file size'
        return
    }

    emit('update:modelValue', file)
}

function processFiles(files: File[]) {
    const size: number = files
        .map(file => file.size)
        .reduce((prev, current) => prev + current, 0)

    if (size > props.maxSize) {
        state.validSize = false
        state.message = 'Files exceed maximum file size'

        return
    }

    emit('update:modelValue', files)
}

let focused: Ref<boolean> = ref(false)

function toggleFocus() {
    focused.value = ! focused.value
}
</script>

<template>
    <div class="group mt-1 flex w-full cursor-pointer flex-col items-center justify-center">
        <div
            class="relative flex h-32 w-full flex-col rounded-lg border-2 border-dotted border-gray-300 transition ease-in-out hover:border-indigo-600 hover:bg-indigo-100"
            :class="{
                'border-red-500': error,
                'bg-indigo-100 border-indigo-600': state.dragActive || focused
            }"
        >
            <span class="flex cursor-pointer flex-col items-center justify-center p-4">
                <svg
                    class="h-12 w-12 text-gray-400 transition ease-in-out group-hover:text-indigo-600"
                    :class="{'text-indigo-600': state.dragActive || focused}"
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
                <span
                    class="pt-1 text-sm text-indigo-500 transition ease-in-out group-hover:text-indigo-600"
                    :class="{'text-indigo-600': state.dragActive || focused}"
                >
                    {{ multiple ? 'Upload files' : 'Upload a file' }}
                </span>
                <span
                    class="text-xs text-gray-500 transition ease-in-out group-hover:text-indigo-600"
                    :class="{'text-indigo-600': state.dragActive || focused}"
                >
                    {{ allowedTypes }} up to {{ maxSizeInMB }}MB
                </span>
            </span>
            <input
                :id="inputId"
                :name="inputName"
                type="file"
                class="absolute h-full w-full cursor-pointer opacity-0"
                :multiple="multiple"
                @focus="toggleFocus"
                @blur="toggleFocus"
                @dragenter.prevent="setDragActive"
                @dragover.prevent="setDragActive"
                @dragleave.prevent="setDragInactive"
                @drop.prevent="onDrop"
                @input="processUpload"
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