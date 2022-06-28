<script setup lang="ts">
import {computed, defineProps, nextTick, onBeforeUnmount, reactive, ref} from 'vue'
import type {ComputedRef, Ref} from 'vue'
import {onClickOutside} from '@vueuse/core'
import {createPopper} from '@popperjs/core'
import type {Instance} from '@popperjs/core'
import type {ComplexSelectOption, SelectOption} from '../../types'

interface Data {
    isOpen: boolean,
    search: string,
    highlightedIndex: number
}

const props = defineProps<{
        modelValue: (string|number)[],
        options: SelectOption[],
        placeholder?: string
}>()

const emit = defineEmits(['update:modelValue'])

let popper: Instance|undefined = undefined

const data: Data = reactive({
    isOpen: false,
    search: '',
    highlightedIndex: 0
})

const input: Ref<HTMLInputElement|null> = ref(null)
const selections: Ref<HTMLInputElement|null> = ref(null)
const toggleInput: Ref<HTMLInputElement|null> = ref(null)
const dropdown: Ref<HTMLInputElement|null> = ref(null)
const search: Ref<HTMLInputElement|null> = ref(null)
const options: Ref<HTMLInputElement|null> = ref(null)

const filteredOptions: ComputedRef<SelectOption[]> = computed(() => filterOptions())
const placeholder: ComputedRef<string> = computed(() => props.placeholder ?? 'Please select...')

onClickOutside(input, () => close())

async function open() {
    if(data.isOpen) return
    data.isOpen = true

    await nextTick()

    setupPopper()
    search.value?.focus()
}

function setupPopper() {
    if (popper !== undefined) {
        popper.update

        return popper
    }

    if(selections.value && dropdown.value) {
        return popper = createPopper(selections.value, dropdown.value, {
            placement: 'bottom',
            modifiers: [
                {
                    name: 'offset',
                    options: {
                        offset: [10, 5],
                    },
                },
            ],
        })
    }

    return popper
}

function close() {
    if(!data.isOpen) return
    data.isOpen = false

    selections.value?.focus()
}

function toggle() {
    if (data.isOpen) {
        data.isOpen = false
        toggleInput.value?.focus()

        return
    }

    open()
}

function select(option: SelectOption) {
    emit('update:modelValue', [...props.modelValue, value(option)])

    data.search = ''
    data.highlightedIndex = 0

    close()
}

function selectHighlighted() {
    if (filteredOptions.value.length === 0) return

    const filteredOption = filteredOptions.value[data.highlightedIndex]

    if (! filteredOption) return

    select(filteredOption)
}

function scrollToHighlighted() {
    options.value?.children[data.highlightedIndex]?.scrollIntoView({ block: 'nearest' })
}

function highlight(index: number) {
    data.highlightedIndex = index

    if(data.highlightedIndex < 0) {
        data.highlightedIndex = filteredOptions.value.length - 1
    }

    if(data.highlightedIndex > filteredOptions.value.length - 1) {
        data.highlightedIndex = 0
    }

    scrollToHighlighted()
}

function highlightPrev() {
    highlight(data.highlightedIndex - 1)
}

function highlightNext() {
    highlight(data.highlightedIndex + 1)
}

function filterOptions() {
    return props.options.filter(option => {
        if (typeof option === 'object') {
            return matchObjectOption(option)
        }

        return matchOption(option)
    })
}

function sanitisedValue(value: string|number) {
    if (typeof value === 'string') {
        return value.toLowerCase()
    }

    return value.toString().toLowerCase()
}

function matchObjectOption(option: ComplexSelectOption) {
    return (sanitisedValue(option.value).startsWith(data.search.toLowerCase())
            || sanitisedValue(option.display).startsWith(data.search.toLowerCase()))
        && ! props.modelValue.includes(option.value)
}

function matchOption(option: string|number) {
    return sanitisedValue(option).startsWith(data.search.toLowerCase())
        && ! props.modelValue.includes(option)
}

function value(option: SelectOption) {
    return typeof option === 'object' && Object.hasOwn(option, 'value')
        ? option.value
        : option
}

function display(option: SelectOption) {
    return typeof option === 'object' && Object.hasOwn(option, 'display')
        ? option.display
        : option
}

function removeSelection(event: Event, selection: string|number) {
    event.stopPropagation()

    emit('update:modelValue', props.modelValue.filter(value => value !== selection))
}

function handleBackspace() {
    emit('update:modelValue', props.modelValue.slice(0, -1))
}

onBeforeUnmount(() => {
    if(popper !== undefined) popper.destroy()
})
</script>

<template>
    <div
        ref="input"
        class="relative"
    >
        <div class="flex relative items-center">
            <button
                ref="selections"
                class="flex flex-wrap items-center space-x-1 w-full text-xs font-semibold text-left rounded border-2 focus:border-transparent focus:outline-none focus:ring focus:ring-blue-400"
                :class="{
                    'py-1 px-2': modelValue.length === 0,
                    'px-1': modelValue.length > 0
                }"
                type="button"
                @click="open"
                @keydown.backspace="handleBackspace"
            >
                <template v-if="modelValue.length > 0">
                    <span
                        v-for="selection in modelValue"
                        :key="selection"
                        class="flex items-center py-0.5 px-1 my-0.5 bg-blue-200 rounded select-none"
                    >
                        <span>{{ selection }}</span>
                        <button
                            type="button"
                            class="mb-0.5 ml-1 text-base leading-none"
                            @click="removeSelection($event, selection)"
                        >&times;</button>
                    </span>
                </template>
                <span
                    v-else
                    class="text-gray-400"
                >{{ placeholder }}</span>
            </button>
            <button
                ref="toggleInput"
                class="flex absolute right-0 justify-center items-center p-1.5 text-xs font-semibold focus:border-transparent focus:outline-none focus:ring focus:ring-blue-400"
                type="button"
                @click="toggle"
            >
                <svg
                    v-show="! data.isOpen"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-3.5 h-3.5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                    />
                </svg>
                <svg
                    v-show="data.isOpen"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-3.5 h-3.5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 15l7-7 7 7"
                    />
                </svg>
            </button>
        </div>
        <div
            v-show="data.isOpen"
            ref="dropdown"
            class="absolute z-10 p-2 w-full text-white bg-select-grey rounded shadow"
        >
            <input
                ref="search"
                v-model="data.search"
                class="py-1 px-2 mb-2 w-full text-xs font-semibold bg-gray-500 rounded border-2 border-gray-400 focus:border-transparent focus:outline-none focus:ring focus:ring-blue-400"
                type="text"
                @keydown.esc="close"
                @keydown.up="highlightPrev"
                @keydown.down="highlightNext"
                @keydown.enter.prevent="selectHighlighted"
                @keydown.tab.prevent
            >
            <ul
                v-show="filteredOptions.length > 0"
                ref="options"
                class="overflow-y-auto relative max-h-48 cursor-pointer"
            >
                <li
                    v-for="(option, index) in filteredOptions"
                    :key="index"
                    class="py-2 px-3 mt-1 text-xs hover:bg-blue-500 rounded"
                    :class="{ 'bg-blue-500': index === data.highlightedIndex }"
                    @click="select(option)"
                >
                    {{ display(option) }}
                </li>
            </ul>
            <div
                v-show="filteredOptions.length === 0"
                class="py-2 px-3 text-xs"
            >
                No results found <span v-show="data.search.length > 0">for "{{ data.search }}"</span>
            </div>
        </div>
    </div>
</template>