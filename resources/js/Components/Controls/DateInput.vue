<script setup lang="ts">
import flatpickr from 'flatpickr'
import confirmDatePlugin from 'flatpickr/dist/plugins/confirmDate/confirmDate'
import 'flatpickr/dist/flatpickr.css'
import 'flatpickr/dist/plugins/confirmDate/confirmDate.css'
import type {Instance} from 'flatpickr/dist/types/instance'
import type {Hook, Plugin} from 'flatpickr/dist/types/options'
import {onBeforeUnmount, onMounted, ref, toRef, watch} from 'vue'
import type {Ref} from 'vue'

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
    },
    baseStartOn: {
        type: String,
        default: ''
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

const baseStartOn: Ref<string> = toRef(props, 'baseStartOn')


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

watch(baseStartOn, () => {
    if (! fp || ! props.baseStartOn) return

    let base: Date = new Date(baseStartOn.value)

    fp.setDate(base)
    emit('update:modelValue', base)
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
            class="date-input block w-full appearance-none rounded-md border border-gray-300 py-2 px-3 shadow-sm placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
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