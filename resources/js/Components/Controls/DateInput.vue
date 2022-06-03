<script setup lang="ts">
import flatpickr from 'flatpickr'
import confirmDatePlugin from 'flatpickr/dist/plugins/confirmDate/confirmDate'
import 'flatpickr/dist/flatpickr.css'
import 'flatpickr/dist/plugins/confirmDate/confirmDate.css'
import type {Instance} from 'flatpickr/dist/types/instance'
import type {Hook, Plugin} from 'flatpickr/dist/types/options'
import {onBeforeUnmount, onMounted, ref} from 'vue'
import type {Ref} from 'vue'

const props = defineProps({
    modelValue: {
        type: String,
        default: () => new Date().toISOString().slice(0, 10)
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
    },
    config: {
        type: Object,
        default: () => {{
            //
        }}
    },
    timeEnabled: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['update:modelValue', 'reset'])

interface FlatpickrConfig {
    altInput: boolean,
    altFormat: string,
    defaultDate: string,
    enableTime: boolean,
    time_24hr: boolean,
    plugins: Plugin[],
    onOpen: () => void,
    onClose: Hook | Hook[] | undefined
}

let fp: Instance | null = null

const formatToUse: string = props.timeEnabled
    ? 'd M Y H:i'
    : 'd M Y'

const baseConfig: FlatpickrConfig = {
    altInput: true,
    altFormat: formatToUse,
    defaultDate: props.modelValue,
    enableTime: props.timeEnabled,
    time_24hr: true,
    plugins: [confirmDatePlugin({})],
    onOpen: openPicker,
    onClose: closePicker
}

const input: Ref<Node|null> = ref(null)

const datePickerOpen: Ref<boolean> = ref(false)


onMounted(() => {
    if (fp || !input.value) {
        return
    }

    fp = flatpickr(input.value, {
        ...baseConfig,
        ...props.config
    })
})

onBeforeUnmount(() => {
    if (!fp) {
        return
    }

    fp.destroy()
})

function openPicker() {
    datePickerOpen.value = true
}

function closePicker(dates: Date[], dateString: string, self: Instance) {
    datePickerOpen.value = false
    handleInput(dateString)
}

function handleInput(dateString: string): void {
    if (props.error) {
        emit('reset')
    }

    emit('update:modelValue', dateString)
}
</script>

<template>
    <div>
        <input
            :id="inputId"
            ref="input"
            :name="inputName"
            type="text"
            class="block py-2 px-3 w-full placeholder:text-gray-400 rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 shadow-sm appearance-none sm:text-sm date-input"
            :class="{'border-red-500': error}"
        >
        <p
            v-if="error"
            class="mt-1 text-sm text-red-500"
        >
            {{ error }}
        </p>
    </div>
</template>