<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import {TransitionRoot, TransitionChild} from '@headlessui/vue'
import {XIcon} from '@heroicons/vue/outline'

defineProps({
    show: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['hide'])

type ActiveTab = 'read'|'unread'

const activeTab: Ref<ActiveTab> = ref('unread')

function setActive(tab: ActiveTab): void {
    activeTab.value = tab
}

function isActive(tab: string): boolean {
    return activeTab.value === tab
}
</script>

<template>
    <TransitionRoot
        as="template"
        :show="show"
    >
        <div
            class="relative z-10"
            aria-labelledby="slide-over-title"
            role="dialog"
            aria-modal="true"
        >
            <div
                v-show="show"
                class="fixed inset-0 bg-indigo-800/50"
            />

            <div class="overflow-hidden fixed inset-0">
                <div class="overflow-hidden absolute inset-0">
                    <div class="flex fixed inset-y-0 right-0 pl-10 max-w-full pointer-events-none sm:pl-16">
                        <TransitionChild
                            as="template"
                            enter="transform transition ease-in-out duration-500 sm:duration-700"
                            enter-from="translate-x-full"
                            enter-to="translate-x-0"
                            leave="transform transition ease-in-out duration-500 sm:duration-700"
                            leave-from="translate-x-0"
                            leave-to="translate-x-full"
                        >
                            <div class="w-screen max-w-md pointer-events-auto">
                                <div class="flex overflow-y-scroll flex-col h-full bg-white shadow-xl">
                                    <div class="p-6">
                                        <div class="flex justify-between items-start">
                                            <h2
                                                id="slide-over-title"
                                                class="text-lg font-medium text-gray-900"
                                            >
                                                Notifications
                                            </h2>
                                            <div class="flex items-center ml-3 h-7">
                                                <button
                                                    type="button"
                                                    class="text-gray-400 hover:text-gray-500 bg-white rounded-md focus:ring-2 focus:ring-indigo-500"
                                                >
                                                    <span class="sr-only">Close panel</span>
                                                    <XIcon
                                                        class="w-6 h-6"
                                                        @click="emit('hide')"
                                                    />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border-b border-gray-200">
                                        <div class="px-6">
                                            <nav class="flex -mb-px space-x-6">
                                                <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
                                                <button
                                                    class="px-1 pb-4 text-sm font-medium whitespace-nowrap border-b-2"
                                                    :class="{
                                                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': ! isActive('unread'),
                                                        'border-indigo-500 text-indigo-600': isActive('unread')
                                                    }"
                                                    @click="setActive('unread')"
                                                >
                                                    Unread
                                                </button>

                                                <button
                                                    class="px-1 pb-4 text-sm font-medium whitespace-nowrap border-b-2"
                                                    :class="{
                                                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': ! isActive('read'),
                                                        'border-indigo-500 text-indigo-600': isActive('read')
                                                    }"
                                                    @click="setActive('read')"
                                                >
                                                    Read
                                                </button>
                                            </nav>
                                        </div>
                                    </div>
                                    <ul
                                        role="list"
                                        class="overflow-y-auto flex-1 divide-y divide-gray-200"
                                    >
                                        <li>
                                            <div class="group flex relative items-center py-6 px-5">
                                                <a
                                                    href="#"
                                                    class="block flex-1 p-1 -m-1"
                                                >
                                                    <div
                                                        class="absolute inset-0 group-hover:bg-gray-50"
                                                        aria-hidden="true"
                                                    />
                                                    <div class="flex relative flex-1 items-center min-w-0">
                                                        <span class="inline-block relative shrink-0">
                                                            <img
                                                                class="w-10 h-10 rounded-full"
                                                                src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                                alt=""
                                                            >
                                                            <!-- Online: "bg-green-400", Offline: "bg-gray-300" -->
                                                            <span
                                                                class="block absolute top-0 right-0 w-2.5 h-2.5 bg-green-400 rounded-full ring-2 ring-white"
                                                                aria-hidden="true"
                                                            />
                                                        </span>
                                                        <div class="ml-4 truncate">
                                                            <p class="text-sm font-medium text-gray-900 truncate">Leslie Alexander</p>
                                                            <p class="text-sm text-gray-500 truncate">@lesliealexander</p>
                                                        </div>
                                                    </div>
                                                </a>
                                                <div class="inline-block relative shrink-0 ml-2 text-left">
                                                    <button
                                                        id="options-menu-0-button"
                                                        type="button"
                                                        class="group inline-flex relative justify-center items-center w-8 h-8 bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                                        aria-expanded="false"
                                                        aria-haspopup="true"
                                                    >
                                                        <span class="sr-only">Open options menu</span>
                                                        <span class="flex justify-center items-center w-full h-full rounded-full">
                                                            <!-- Heroicon name: solid/dots-vertical -->
                                                            <svg
                                                                class="w-5 h-5 text-gray-400 group-hover:text-gray-500"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 20 20"
                                                                fill="currentColor"
                                                                aria-hidden="true"
                                                            >
                                                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                                            </svg>
                                                        </span>
                                                    </button>

                                                    <!--
                                              Dropdown panel, show/hide based on dropdown state.

                                              Entering: "transition ease-out duration-100"
                                                From: "transform opacity-0 scale-95"
                                                To: "transform opacity-100 scale-100"
                                              Leaving: "transition ease-in duration-75"
                                                From: "transform opacity-100 scale-100"
                                                To: "transform opacity-0 scale-95"
                                            -->
                                                    <div
                                                        class="absolute top-0 right-9 z-10 w-48 bg-white rounded-md focus:outline-none ring-1 ring-black ring-opacity-5 shadow-lg origin-top-right"
                                                        role="menu"
                                                        aria-orientation="vertical"
                                                        aria-labelledby="options-menu-0-button"
                                                        tabindex="-1"
                                                    >
                                                        <div
                                                            class="py-1"
                                                            role="none"
                                                        >
                                                            <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                                            <a
                                                                id="options-menu-0-item-0"
                                                                href="#"
                                                                class="block py-2 px-4 text-sm text-gray-700"
                                                                role="menuitem"
                                                                tabindex="-1"
                                                            >View profile</a>
                                                            <a
                                                                id="options-menu-0-item-1"
                                                                href="#"
                                                                class="block py-2 px-4 text-sm text-gray-700"
                                                                role="menuitem"
                                                                tabindex="-1"
                                                            >Send message</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                        <!-- More people... -->
                                    </ul>
                                </div>
                            </div>
                        </TransitionChild>
                    </div>
                </div>
            </div>
        </div>
    </TransitionRoot>
</template>