<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import {onClickOutside} from '@vueuse/core'
import {TransitionRoot} from '@headlessui/vue'

type Position = 'below-left' | 'below-center' | 'below-right' | 'above-left' | 'above-center' | 'above-right'

const props = defineProps<{
    modelValue: boolean,
    position: Position
}>()

const emit = defineEmits(['update:modelValue'])

const dropdown: Ref<HTMLDivElement | null> = ref(null)

function showDropdown() {
    emit('update:modelValue', true)
}

function hideDropdown() {
    emit('update:modelValue', false)
}

function toggleDropdown() {
    emit('update:modelValue', ! props.modelValue)
}

onClickOutside(dropdown, () => hideDropdown())
</script>

<template>
    <div
        ref="dropdown"
        class="relative"
    >
        <slot
            name="button"
            :show-dropdown="showDropdown"
            :hide-dropdown="hideDropdown"
            :toggle-dropdown="toggleDropdown"
        >
            <div>
                <button
                    class="text-gray-600 hover:text-indigo-600 focus:text-indigo-600 focus:outline-none"
                    aria-expanded="true"
                    aria-haspopup="true"
                    @click="toggleDropdown"
                >
                    <span class="sr-only">Open options</span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        color="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"
                        />
                    </svg>
                </button>
            </div>
        </slot>
        <TransitionRoot
            :show="modelValue"
            as="template"
            enter="transition ease-in-out duration-300"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="transition ease-in-out duration-300"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
        >
            <div
                v-show="modelValue"
                class="z-20 absolute w-max rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                :class="{
                    'mt-2 origin-top-left left-0': position === 'below-left',
                    'mt-2 origin-top-right right-0': position === 'below-right',
                    'mt-2 origin-top-right right-0 transform translate-x-1/2': position === 'below-center',
                    '-mt-2 top-0 left-0 transform -translate-y-full': position === 'above-left',
                    '-mt-2 top-0 right-0 transform -translate-y-full': position === 'above-right',
                    '-mt-2 top-0 right-0 transform -translate-y-full translate-x-1/2': position === 'above-center'
                }"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="menu-button"
                tabindex="-1"
            >
                <slot
                    :show-dropdown="showDropdown"
                    :hide-dropdown="hideDropdown"
                    :toggle-dropdown="toggleDropdown"
                />
            </div>
        </TransitionRoot>
    </div>
</template>

<style>
.toggle-enter-active,
.toggle-leave-active {
    @apply transition ease-out duration-100;
}

.toggle-enter-from,
.toggle-leave-to {
    @apply transform opacity-0 scale-95;
}
.toggle-leave-from,
.toggle-enter-to {
    @apply transform opacity-100 scale-100;
}
</style>