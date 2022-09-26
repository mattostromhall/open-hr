<script setup lang="ts">
import {computed, nextTick, onBeforeUnmount, reactive, ref} from 'vue'
import type {ComputedRef, Ref} from 'vue'
import {onClickOutside} from '@vueuse/core'
import {createPopper} from '@popperjs/core'
import type {Instance} from '@popperjs/core'
import type {ComplexSelectOption, SelectOption} from '../../types'
import {ChevronDownIcon, ChevronUpIcon} from '@heroicons/vue/24/solid'

const props = defineProps<{
    modelValue: (string|number)[],
    options: SelectOption[],
    error?: string,
    placeholder?: string
}>()

const emit = defineEmits(['update:modelValue', 'reset'])

interface Data {
    isOpen: boolean,
    search: string,
    highlightedIndex: number
}

const data: Data = reactive({
    isOpen: false,
    search: '',
    highlightedIndex: 0
})

let popper: Instance|undefined = undefined

const input: Ref<HTMLInputElement|null> = ref(null)
const selections: Ref<HTMLInputElement|null> = ref(null)
const toggleInput: Ref<HTMLInputElement|null> = ref(null)
const dropdown: Ref<HTMLInputElement|null> = ref(null)
const search: Ref<HTMLInputElement|null> = ref(null)
const options: Ref<HTMLInputElement|null> = ref(null)

const placeholder: ComputedRef<string> = computed(() => props.placeholder ?? 'Please select...')
const filteredOptions: ComputedRef<SelectOption[]> = computed(() => filterOptions())
const selectionData: ComputedRef<({
    optionValue:string|number, optionDisplay: string|number
})[]> = computed(() => props.modelValue.flatMap(selection => {
    return props.options.filter(option => value(option) === selection)
        .map(option => {
            return {
                optionValue: value(option),
                optionDisplay: display(option)
            }
        })
}))

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
                        offset: [5, 5],
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
    if (props.error) {
        emit('reset')
    }

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
    return (sanitisedValue(option.value).includes(data.search.toLowerCase())
            || sanitisedValue(option.display).includes(data.search.toLowerCase()))
        && ! props.modelValue.includes(option.value)
}

function matchOption(option: string|number) {
    return sanitisedValue(option).includes(data.search.toLowerCase())
        && ! props.modelValue.includes(option)
}

function value(option: SelectOption) {
    if (typeof option === 'object' && Object.hasOwn(option, 'value')) {
        return option.value
    }

    if (typeof option === 'string' || typeof option === 'number') {
        return option
    }

    return ''
}

function display(option: SelectOption) {
    if (typeof option === 'object' && Object.hasOwn(option, 'display')) {
        return option.display
    }

    if (typeof option === 'string' || typeof option === 'number') {
        return option
    }

    return ''
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
        <div class="relative flex items-center">
            <button
                ref="selections"
                class="flex w-full appearance-none flex-wrap items-center space-x-1 rounded-md border border-gray-300 text-left text-xs font-semibold shadow-sm placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                :class="{
                    'py-1.5 pl-2 pr-6': modelValue.length > 0,
                    'py-2 px-3': modelValue.length === 0,
                    'border-red-500': error
                }"
                type="button"
                @click="open"
                @keydown.backspace="handleBackspace"
            >
                <template v-if="modelValue.length > 0">
                    <span
                        v-for="{optionValue, optionDisplay} in selectionData"
                        :key="optionValue"
                        class="my-0.5 flex select-none items-center rounded bg-indigo-100 py-0.5 px-1 text-indigo-800"
                    >
                        <span>{{ optionDisplay }}</span>
                        <button
                            type="button"
                            class="mb-0.5 ml-1 text-base leading-none"
                            @click="removeSelection($event, optionValue)"
                        >&times;</button>
                    </span>
                </template>
                <span v-else>{{ placeholder }}</span>
            </button>
            <button
                ref="toggleInput"
                class="absolute right-0 flex h-full items-center justify-center p-1.5 text-xs font-semibold focus:border-transparent focus:outline-none focus:ring focus:ring-indigo-400"
                type="button"
                @click="toggle"
            >
                <ChevronDownIcon
                    v-show="! data.isOpen"
                    class="h-3.5 w-3.5"
                />
                <ChevronUpIcon
                    v-show="data.isOpen"
                    class="h-3.5 w-3.5"
                />
            </button>
        </div>
        <p
            v-if="error"
            class="mt-1 text-sm text-red-500"
        >
            {{ error }}
        </p>
        <div
            v-show="data.isOpen"
            ref="dropdown"
            class="absolute z-10 w-full rounded bg-select-grey p-2 text-white shadow"
        >
            <input
                ref="search"
                v-model="data.search"
                class="mb-2 w-full rounded border-gray-400 bg-gray-500 py-1 px-2 text-xs font-semibold focus:border-transparent focus:outline-none focus:ring focus:ring-indigo-400"
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
                class="relative max-h-48 cursor-pointer overflow-y-auto"
            >
                <li
                    v-for="(option, index) in filteredOptions"
                    :key="index"
                    class="mt-1 rounded py-2 px-3 text-xs hover:bg-indigo-500"
                    :class="{ 'bg-indigo-500': index === data.highlightedIndex }"
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