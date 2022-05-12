<script setup lang="ts">
import {TransitionRoot, TransitionChild} from '@headlessui/vue'
import {CalendarIcon, ChartBarIcon, FolderIcon, HomeIcon, InboxIcon, UsersIcon, XIcon} from '@heroicons/vue/outline'
import {Link} from '@inertiajs/inertia-vue3'

const props = defineProps({
    show: Boolean
})

defineEmits(['hide'])
</script>

<template>
    <TransitionRoot
        as="template"
        :show="props.show"
    >
        <div
            class="flex fixed inset-0 z-40 md:hidden"
            role="dialog"
            aria-modal="true"
        >
            <TransitionChild
                as="template"
                enter="transition-opacity ease-linear duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="transition-opacity ease-linear duration-300"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div
                    class="fixed inset-0 bg-gray-600 bg-opacity-75"
                    aria-hidden="true"
                />
            </TransitionChild>
            <TransitionChild
                as="template"
                enter="transition ease-in-out duration-300 transform"
                enter-from="-translate-x-full"
                enter-to="translate-x-0"
                leave="transition ease-in-out duration-300 transform"
                leave-from="translate-x-0"
                leave-to="-translate-x-full"
            >
                <div class="flex relative flex-col flex-1 w-full max-w-xs bg-gradient-to-r from-indigo-700 to-indigo-600">
                    <TransitionChild
                        as="template"
                        enter="ease-in-out duration-300"
                        enter-from="opacity-0"
                        enter-to="opacity-100"
                        leave="ease-in-out duration-300"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                    >
                        <div class="absolute top-0 right-0 pt-2 -mr-12">
                            <button
                                type="button"
                                class="flex justify-center items-center ml-1 w-10 h-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                @click="$emit('hide', false)"
                            >
                                <span class="sr-only">Close sidebar</span>
                                <XIcon
                                    class="w-6 h-6 text-white"
                                    aria-hidden="true"
                                />
                            </button>
                        </div>
                    </TransitionChild>
                    <div class="overflow-y-auto flex-1 pt-5 pb-4 h-0">
                        <div class="flex shrink-0 items-center px-4">
                            <img
                                class="w-auto h-8"
                                src="https://tailwindui.com/img/logos/workflow-logo-indigo-300-mark-white-text.svg"
                                alt="Workflow"
                            >
                        </div>
                        <nav class="px-2 mt-5 space-y-1">
                            <!-- Current: "bg-indigo-800 text-white", Default: "text-white hover:bg-indigo-500 hover:bg-opacity-75" -->
                            <a
                                href="#"
                                class="group flex items-center p-2 text-base font-medium text-white bg-indigo-800 rounded-md"
                            >
                                <HomeIcon
                                    class="shrink-0 mr-4 w-6 h-6 text-indigo-300"
                                    aria-hidden="true"
                                />
                                Dashboard
                            </a>

                            <a
                                href="#"
                                class="group flex items-center p-2 text-base font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75 rounded-md"
                            >
                                <UsersIcon
                                    class="shrink-0 mr-4 w-6 h-6 text-indigo-300"
                                    aria-hidden="true"
                                />
                                Team
                            </a>

                            <a
                                href="#"
                                class="group flex items-center p-2 text-base font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75 rounded-md"
                            >
                                <FolderIcon
                                    class="shrink-0 mr-4 w-6 h-6 text-indigo-300"
                                    aria-hidden="true"
                                />
                                Projects
                            </a>

                            <a
                                href="#"
                                class="group flex items-center p-2 text-base font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75 rounded-md"
                            >
                                <CalendarIcon
                                    class="shrink-0 mr-4 w-6 h-6 text-indigo-300"
                                    aria-hidden="true"
                                />
                                Calendar
                            </a>

                            <a
                                href="#"
                                class="group flex items-center p-2 text-base font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75 rounded-md"
                            >
                                <InboxIcon
                                    class="shrink-0 mr-4 w-6 h-6 text-indigo-300"
                                    aria-hidden="true"
                                />
                                Documents
                            </a>

                            <a
                                href="#"
                                class="group flex items-center p-2 text-base font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75 rounded-md"
                            >
                                <ChartBarIcon
                                    class="shrink-0 mr-4 w-6 h-6 text-indigo-300"
                                    aria-hidden="true"
                                />
                                Reports
                            </a>
                        </nav>
                    </div>
                    <div class="flex shrink-0 p-4 border-t border-indigo-800">
                        <a
                            href="#"
                            class="group block shrink-0"
                        >
                            <div class="flex items-center">
                                <div>
                                    <img
                                        class="inline-block w-10 h-10 rounded-full"
                                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                        alt=""
                                    >
                                </div>
                                <div class="ml-3">
                                    <p class="text-base font-medium text-white">Tom Cook</p>
                                    <p class="text-sm font-medium text-indigo-200 group-hover:text-white">View profile</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </TransitionChild>
            <div
                class="shrink-0 w-14"
                aria-hidden="true"
            />
        </div>
    </TransitionRoot>
    <div class="hidden md:flex md:fixed md:inset-y-0 md:flex-col md:w-64">
        <div class="flex flex-col flex-1 min-h-0 bg-gradient-to-r from-indigo-700 to-indigo-600">
            <div class="flex overflow-y-auto flex-col flex-1 pt-5 pb-4">
                <div class="flex shrink-0 items-center px-4">
                    <h2 class="text-2xl font-bold text-white">
                        Open HR
                    </h2>
                </div>
                <nav class="flex-1 px-2 mt-5 space-y-1">
                    <!-- Current: "bg-indigo-800 text-white", Default: "text-white hover:bg-indigo-500 hover:bg-opacity-75" -->
                    <a
                        href="#"
                        class="group flex items-center p-2 text-sm font-medium text-white bg-indigo-800 rounded-md"
                    >
                        <HomeIcon
                            class="shrink-0 mr-3 w-6 h-6 text-indigo-300"
                            aria-hidden="true"
                        />
                        Dashboard
                    </a>

                    <a
                        href="#"
                        class="group flex items-center p-2 text-sm font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75 rounded-md"
                    >
                        <UsersIcon
                            class="shrink-0 mr-3 w-6 h-6 text-indigo-300"
                            aria-hidden="true"
                        />
                        Team
                    </a>

                    <a
                        href="#"
                        class="group flex items-center p-2 text-sm font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75 rounded-md"
                    >
                        <FolderIcon
                            class="shrink-0 mr-3 w-6 h-6 text-indigo-300"
                            aria-hidden="true"
                        />
                        Projects
                    </a>

                    <a
                        href="#"
                        class="group flex items-center p-2 text-sm font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75 rounded-md"
                    >
                        <CalendarIcon
                            class="shrink-0 mr-3 w-6 h-6 text-indigo-300"
                            aria-hidden="true"
                        />
                        Calendar
                    </a>

                    <a
                        href="#"
                        class="group flex items-center p-2 text-sm font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75 rounded-md"
                    >
                        <InboxIcon
                            class="shrink-0 mr-3 w-6 h-6 text-indigo-300"
                            aria-hidden="true"
                        />
                        Documents
                    </a>

                    <a
                        href="#"
                        class="group flex items-center p-2 text-sm font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75 rounded-md"
                    >
                        <ChartBarIcon
                            class="shrink-0 mr-3 w-6 h-6 text-indigo-300"
                            aria-hidden="true"
                        />
                        Reports
                    </a>
                </nav>
            </div>
            <div class="flex shrink-0 p-4 border-t border-indigo-800">
                <a
                    href="#"
                    class="group block shrink-0 w-full"
                >
                    <div class="flex items-center">
                        <div>
                            <img
                                class="inline-block w-9 h-9 rounded-full"
                                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt=""
                            >
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">Tom Cook</p>
                            <p class="text-xs font-medium text-indigo-200 group-hover:text-white">View profile</p>
                            <Link
                                href="/logout"
                                method="post"
                                as="button"
                                class="text-xs font-medium text-indigo-200 group-hover:text-white"
                            >
                                Log Out
                            </Link>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>