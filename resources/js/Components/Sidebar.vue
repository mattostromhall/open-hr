<script setup lang="ts">
import {TransitionRoot, TransitionChild} from '@headlessui/vue'
import {BellIcon, CalendarIcon, ChartBarIcon, FolderIcon, HomeIcon, UserIcon, UsersIcon, XMarkIcon} from '@heroicons/vue/24/outline'
import {Link} from '@inertiajs/inertia-vue3'
import {computed} from 'vue'
import type {ComputedRef} from 'vue'
import usePerson from '../Hooks/usePerson'
import useNotifications from '../Hooks/useNotifications'
import useNotificationsSlideOver from '../Composables/useNotificationsSlideOver'
import useSidebar from '../Composables/useSidebar'

const person = usePerson()
const sidebar = useSidebar()
const {showNotifications} = useNotificationsSlideOver()

const name: ComputedRef<string> = computed(() => {
    return person.value?.full_name ?? ''
})

const initials: ComputedRef<string> = computed(() => {
    return person.value?.initials ?? ''
})

const notificationCount: ComputedRef<number> = computed(() => useNotifications().value
    .filter(notification => ! notification.read)
    .length)
</script>

<template>
    <TransitionRoot
        as="template"
        :show="sidebar.show.value"
    >
        <div
            class="fixed inset-0 z-40 flex md:hidden"
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
                <div class="relative flex w-full max-w-xs flex-1 flex-col bg-gradient-to-r from-indigo-700 to-indigo-600">
                    <TransitionChild
                        as="template"
                        enter="ease-in-out duration-300"
                        enter-from="opacity-0"
                        enter-to="opacity-100"
                        leave="ease-in-out duration-300"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                    >
                        <div class="absolute top-0 right-0 -mr-12 pt-2">
                            <button
                                type="button"
                                class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                @click="sidebar.hideSidebar"
                            >
                                <span class="sr-only">Close sidebar</span>
                                <XMarkIcon
                                    class="h-6 w-6 text-white"
                                    aria-hidden="true"
                                />
                            </button>
                        </div>
                    </TransitionChild>
                    <div class="h-0 flex-1 overflow-y-auto pt-5 pb-4">
                        <div class="flex shrink-0 items-center px-4">
                            <img
                                class="h-8 w-auto"
                                src="https://tailwindui.com/img/logos/workflow-logo-indigo-300-mark-white-text.svg"
                                alt="Workflow"
                            >
                        </div>
                        <nav class="mt-5 space-y-1 px-2">
                            <Link
                                href="/dashboard"
                                class="group flex items-center rounded-md p-2 text-base font-medium text-white"
                                :class="{
                                    'hover:bg-indigo-500 hover:bg-opacity-75': $page.url !== '/dashboard',
                                    'bg-indigo-800': $page.url === '/dashboard'
                                }"
                            >
                                <HomeIcon
                                    class="mr-4 h-6 w-6 shrink-0 text-indigo-300"
                                    aria-hidden="true"
                                />
                                Dashboard
                            </Link>

                            <Link
                                href="/people"
                                class="group flex items-center rounded-md p-2 text-base font-medium text-white"
                                :class="{
                                    'hover:bg-indigo-500 hover:bg-opacity-75': $page.url !== '/people',
                                    'bg-indigo-800': $page.url === '/people'
                                }"
                            >
                                <UserIcon
                                    class="mr-4 h-6 w-6 shrink-0 text-indigo-300"
                                    aria-hidden="true"
                                />
                                People
                            </Link>

                            <Link
                                href="/people"
                                class="group flex items-center rounded-md p-2 text-base font-medium text-white"
                                :class="{
                                    'hover:bg-indigo-500 hover:bg-opacity-75': $page.url !== '/performance',
                                    'bg-indigo-800': $page.url === '/performance'
                                }"
                            >
                                <UsersIcon
                                    class="mr-4 h-6 w-6 shrink-0 text-indigo-300"
                                    aria-hidden="true"
                                />
                                Performance
                            </Link>

                            <a
                                href="#"
                                class="group flex items-center rounded-md p-2 text-base font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75"
                            >
                                <CalendarIcon
                                    class="mr-4 h-6 w-6 shrink-0 text-indigo-300"
                                    aria-hidden="true"
                                />
                                Calendar
                            </a>

                            <Link
                                href="/documents"
                                class="group flex items-center rounded-md p-2 text-base font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75"
                            >
                                <FolderIcon
                                    class="mr-4 h-6 w-6 shrink-0 text-indigo-300"
                                    aria-hidden="true"
                                />
                                Documents
                            </Link>

                            <a
                                href="#"
                                class="group flex items-center rounded-md p-2 text-base font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75"
                            >
                                <ChartBarIcon
                                    class="mr-4 h-6 w-6 shrink-0 text-indigo-300"
                                    aria-hidden="true"
                                />
                                Reports
                            </a>
                            <div>
                                <div class="my-6 border-t border-indigo-800" />
                            </div>
                            <button
                                class="group relative flex w-full items-center rounded-md p-2 text-base font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75"
                                @click="showNotifications"
                            >
                                <span
                                    v-show="notificationCount"
                                    class="absolute -top-1 left-6 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs"
                                >{{ notificationCount }}</span>
                                <BellIcon
                                    class="mr-4 h-6 w-6 shrink-0 text-indigo-300"
                                    aria-hidden="true"
                                />
                                Notifications
                            </button>
                        </nav>
                    </div>
                    <div class="flex shrink-0 border-t border-indigo-800 p-4">
                        <a
                            href="#"
                            class="group block shrink-0"
                        >
                            <div class="flex items-center">
                                <div>
                                    <img
                                        class="inline-block h-10 w-10 rounded-full"
                                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                        alt=""
                                    >
                                </div>
                                <div class="ml-3">
                                    <p class="text-base font-medium text-white">{{ name }}</p>
                                    <Link
                                        :href="'/people/' + person.id + '/profile'"
                                        class="block text-sm font-medium text-indigo-200 group-hover:text-white"
                                    >View profile</Link>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </TransitionChild>
            <div
                class="w-14 shrink-0"
                aria-hidden="true"
            />
        </div>
    </TransitionRoot>
    <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
        <div class="flex min-h-0 flex-1 flex-col bg-gradient-to-r from-indigo-700 to-indigo-600">
            <div class="flex flex-1 flex-col overflow-y-auto pt-5 pb-4">
                <div class="flex shrink-0 items-center px-4">
                    <h2 class="text-2xl font-bold text-white">
                        Open HR
                    </h2>
                </div>
                <nav class="mt-5 flex-1 space-y-1 px-2">
                    <Link
                        href="/dashboard"
                        class="group flex items-center rounded-md p-2 text-sm font-medium text-white"
                        :class="{
                            'hover:bg-indigo-500 hover:bg-opacity-75': $page.url !== '/dashboard',
                            'bg-indigo-800': $page.url === '/dashboard'
                        }"
                    >
                        <HomeIcon
                            class="mr-3 h-6 w-6 shrink-0 text-indigo-300"
                            aria-hidden="true"
                        />
                        Dashboard
                    </Link>

                    <Link
                        href="/people"
                        class="group flex items-center rounded-md p-2 text-sm font-medium text-white"
                        :class="{
                            'hover:bg-indigo-500 hover:bg-opacity-75': $page.url !== '/people',
                            'bg-indigo-800': $page.url === '/people'
                        }"
                    >
                        <UserIcon
                            class="mr-3 h-6 w-6 shrink-0 text-indigo-300"
                            aria-hidden="true"
                        />
                        People
                    </Link>

                    <Link
                        href="/performance"
                        class="group flex items-center rounded-md p-2 text-sm font-medium text-white"
                        :class="{
                            'hover:bg-indigo-500 hover:bg-opacity-75': $page.url !== '/performance',
                            'bg-indigo-800': $page.url === '/performance'
                        }"
                    >
                        <UsersIcon
                            class="mr-3 h-6 w-6 shrink-0 text-indigo-300"
                            aria-hidden="true"
                        />
                        Performance
                    </Link>

                    <a
                        href="#"
                        class="group flex items-center rounded-md p-2 text-sm font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75"
                    >
                        <CalendarIcon
                            class="mr-3 h-6 w-6 shrink-0 text-indigo-300"
                            aria-hidden="true"
                        />
                        Calendar
                    </a>

                    <Link
                        href="/documents"
                        class="group flex items-center rounded-md p-2 text-sm font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75"
                    >
                        <FolderIcon
                            class="mr-3 h-6 w-6 shrink-0 text-indigo-300"
                            aria-hidden="true"
                        />
                        Documents
                    </Link>

                    <a
                        href="#"
                        class="group flex items-center rounded-md p-2 text-sm font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75"
                    >
                        <ChartBarIcon
                            class="mr-3 h-6 w-6 shrink-0 text-indigo-300"
                            aria-hidden="true"
                        />
                        Reports
                    </a>
                    <div>
                        <div class="my-6 border-t border-indigo-800" />
                    </div>
                    <button
                        class="group relative flex w-full items-center rounded-md p-2 text-sm font-medium text-white hover:bg-indigo-500 hover:bg-opacity-75"
                        @click="showNotifications"
                    >
                        <span
                            v-show="notificationCount"
                            class="absolute -top-1 left-6 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs"
                        >{{ notificationCount }}</span>
                        <BellIcon
                            class="mr-3 h-6 w-6 shrink-0 text-indigo-300"
                            aria-hidden="true"
                        />
                        Notifications
                    </button>
                </nav>
            </div>
            <div class="flex shrink-0 border-t border-indigo-800 p-4">
                <div class="group block w-full shrink-0">
                    <div class="flex items-center">
                        <div>
                            <div class="flex h-10 w-10 items-center justify-center rounded-full border border-white bg-gradient-to-r from-indigo-700 to-indigo-500 font-bold text-indigo-50">
                                <span
                                    v-if="initials"
                                    class="text-xs"
                                >
                                    {{ initials }}
                                </span>
                                <svg
                                    v-else
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">
                                {{ name }}
                            </p>
                            <Link
                                :href="'/people/' + person.id + '/profile'"
                                class="block text-xs font-medium text-indigo-200 group-hover:text-white"
                            >
                                View profile
                            </Link>
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
                </div>
            </div>
        </div>
    </div>
</template>