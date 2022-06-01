<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'

const props = defineProps({
    person: {
        type: Object,
        required: true
    },
    holidayRemaining: {
        type: Number,
        default: 0
    },
    sickDaysRemaining: {
        type: Number,
        default: 0
    },
    announcements: {
        type: Array,
        default: () => []
    }
})
</script>

<template>
    <Head title="Dashboard" />

    <section class="p-8">
        <div class="px-4 mx-auto max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl">
            <h1 class="sr-only">
                Profile
            </h1>
            <!-- Main 3 column grid -->
            <div class="grid grid-cols-1 gap-4 items-start lg:grid-cols-3 lg:gap-8">
                <!-- Left column -->
                <div class="grid grid-cols-1 gap-4 lg:col-span-2">
                    <!-- Welcome panel -->
                    <section aria-labelledby="profile-overview-title">
                        <div class="overflow-hidden bg-white rounded-lg shadow">
                            <h2
                                id="profile-overview-title"
                                class="sr-only"
                            >
                                Profile Overview
                            </h2>
                            <div class="p-6 bg-white">
                                <div class="sm:flex sm:justify-between sm:items-center">
                                    <div class="sm:flex sm:space-x-5">
                                        <div class="shrink-0">
                                            <div class="flex justify-center items-center w-20 h-20 font-bold text-indigo-50 bg-gradient-to-r from-indigo-700 to-indigo-500 rounded-full">
                                                <span v-if="props.person.initials">
                                                    {{ props.person.initials }}
                                                </span>
                                                <svg
                                                    v-else
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="w-8 h-8"
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
                                        <div class="mt-4 text-center sm:pt-1 sm:mt-0 sm:text-left">
                                            <p class="text-sm font-medium text-gray-600">
                                                Welcome back,
                                            </p>
                                            <p class="text-xl font-bold text-gray-900 sm:text-2xl">
                                                {{ props.person.full_name }}
                                            </p>
                                            <p class="text-sm font-medium text-gray-600">
                                                {{ props.person.position }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex justify-center mt-5 sm:mt-0">
                                        <a
                                            href="#"
                                            class="flex justify-center items-center py-2 px-4 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 rounded-md border border-gray-300 shadow-sm"
                                        > View profile </a>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 bg-gray-50 border-t border-gray-200 divide-y divide-gray-200 sm:grid-cols-2 sm:divide-y-0 sm:divide-x">
                                <div class="py-5 px-6 text-sm font-medium text-center">
                                    <span class="font-semibold text-gray-900">{{ props.holidayRemaining }}</span>
                                    <span class="text-gray-600"> Holiday days remaining</span>
                                </div>
                                <div class="py-5 px-6 text-sm font-medium text-center">
                                    <span class="font-semibold text-gray-900">{{ props.sickDaysRemaining }}</span>
                                    <span class="text-gray-600"> Sick days remaining</span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Actions panel -->
                    <section aria-labelledby="quick-links-title">
                        <div class="overflow-hidden bg-gray-200 rounded-lg divide-y divide-gray-200 shadow sm:grid sm:grid-cols-2 sm:gap-px sm:divide-y-0">
                            <h2
                                id="quick-links-title"
                                class="sr-only"
                            >
                                Quick links
                            </h2>

                            <div class="group relative p-6 bg-white rounded-t-lg focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500 sm:rounded-tr-none">
                                <div>
                                    <span class="inline-flex p-3 text-teal-700 bg-teal-50 rounded-lg ring-4 ring-white">
                                        <!-- Heroicon name: outline/clock -->
                                        <svg
                                            class="w-6 h-6"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                            />
                                        </svg>
                                    </span>
                                </div>
                                <div class="mt-8">
                                    <h3 class="text-lg font-medium">
                                        <a
                                            href="#"
                                            class="focus:outline-none"
                                        >
                                            <!-- Extend touch target to entire panel -->
                                            <span
                                                class="absolute inset-0"
                                                aria-hidden="true"
                                            />
                                            Request time off
                                        </a>
                                    </h3>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Doloribus dolores nostrum quia qui natus officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et molestiae.
                                    </p>
                                </div>
                                <span
                                    class="absolute top-6 right-6 text-gray-300 group-hover:text-gray-400 pointer-events-none"
                                    aria-hidden="true"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                                    </svg>
                                </span>
                            </div>

                            <div class="group relative p-6 bg-white focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500 sm:rounded-tr-lg">
                                <div>
                                    <span class="inline-flex p-3 text-purple-700 bg-purple-50 rounded-lg ring-4 ring-white">
                                        <!-- Heroicon name: outline/badge-check -->
                                        <svg
                                            class="w-6 h-6"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"
                                            />
                                        </svg>
                                    </span>
                                </div>
                                <div class="mt-8">
                                    <h3 class="text-lg font-medium">
                                        <a
                                            href="#"
                                            class="focus:outline-none"
                                        >
                                            <!-- Extend touch target to entire panel -->
                                            <span
                                                class="absolute inset-0"
                                                aria-hidden="true"
                                            />
                                            Benefits
                                        </a>
                                    </h3>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Doloribus dolores nostrum quia qui natus officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et molestiae.
                                    </p>
                                </div>
                                <span
                                    class="absolute top-6 right-6 text-gray-300 group-hover:text-gray-400 pointer-events-none"
                                    aria-hidden="true"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                                    </svg>
                                </span>
                            </div>

                            <div class="group relative p-6 bg-white focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                                <div>
                                    <span class="inline-flex p-3 text-sky-700 bg-sky-50 rounded-lg ring-4 ring-white">
                                        <!-- Heroicon name: outline/users -->
                                        <svg
                                            class="w-6 h-6"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                                            />
                                        </svg>
                                    </span>
                                </div>
                                <div class="mt-8">
                                    <h3 class="text-lg font-medium">
                                        <a
                                            href="#"
                                            class="focus:outline-none"
                                        >
                                            <!-- Extend touch target to entire panel -->
                                            <span
                                                class="absolute inset-0"
                                                aria-hidden="true"
                                            />
                                            Schedule a one-on-one
                                        </a>
                                    </h3>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Doloribus dolores nostrum quia qui natus officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et molestiae.
                                    </p>
                                </div>
                                <span
                                    class="absolute top-6 right-6 text-gray-300 group-hover:text-gray-400 pointer-events-none"
                                    aria-hidden="true"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                                    </svg>
                                </span>
                            </div>

                            <div class="group relative p-6 bg-white focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500">
                                <div>
                                    <span class="inline-flex p-3 text-yellow-700 bg-yellow-50 rounded-lg ring-4 ring-white">
                                        <!-- Heroicon name: outline/cash -->
                                        <svg
                                            class="w-6 h-6"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"
                                            />
                                        </svg>
                                    </span>
                                </div>
                                <div class="mt-8">
                                    <h3 class="text-lg font-medium">
                                        <a
                                            href="#"
                                            class="focus:outline-none"
                                        >
                                            <!-- Extend touch target to entire panel -->
                                            <span
                                                class="absolute inset-0"
                                                aria-hidden="true"
                                            />
                                            Payroll
                                        </a>
                                    </h3>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Doloribus dolores nostrum quia qui natus officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et molestiae.
                                    </p>
                                </div>
                                <span
                                    class="absolute top-6 right-6 text-gray-300 group-hover:text-gray-400 pointer-events-none"
                                    aria-hidden="true"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                                    </svg>
                                </span>
                            </div>

                            <div class="group relative p-6 bg-white focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500 sm:rounded-bl-lg">
                                <div>
                                    <span class="inline-flex p-3 text-rose-700 bg-rose-50 rounded-lg ring-4 ring-white">
                                        <!-- Heroicon name: outline/receipt-refund -->
                                        <svg
                                            class="w-6 h-6"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"
                                            />
                                        </svg>
                                    </span>
                                </div>
                                <div class="mt-8">
                                    <h3 class="text-lg font-medium">
                                        <a
                                            href="#"
                                            class="focus:outline-none"
                                        >
                                            <!-- Extend touch target to entire panel -->
                                            <span
                                                class="absolute inset-0"
                                                aria-hidden="true"
                                            />
                                            Submit an expense
                                        </a>
                                    </h3>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Doloribus dolores nostrum quia qui natus officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et molestiae.
                                    </p>
                                </div>
                                <span
                                    class="absolute top-6 right-6 text-gray-300 group-hover:text-gray-400 pointer-events-none"
                                    aria-hidden="true"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                                    </svg>
                                </span>
                            </div>

                            <div class="group relative p-6 bg-white rounded-b-lg focus-within:ring-2 focus-within:ring-inset focus-within:ring-cyan-500 sm:rounded-bl-none">
                                <div>
                                    <span class="inline-flex p-3 text-indigo-700 bg-indigo-50 rounded-lg ring-4 ring-white">
                                        <!-- Heroicon name: outline/academic-cap -->
                                        <svg
                                            class="w-6 h-6"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"
                                            />
                                        </svg>
                                    </span>
                                </div>
                                <div class="mt-8">
                                    <h3 class="text-lg font-medium">
                                        <a
                                            href="#"
                                            class="focus:outline-none"
                                        >
                                            <!-- Extend touch target to entire panel -->
                                            <span
                                                class="absolute inset-0"
                                                aria-hidden="true"
                                            />
                                            Training
                                        </a>
                                    </h3>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Doloribus dolores nostrum quia qui natus officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et molestiae.
                                    </p>
                                </div>
                                <span
                                    class="absolute top-6 right-6 text-gray-300 group-hover:text-gray-400 pointer-events-none"
                                    aria-hidden="true"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Right column -->
                <div class="grid grid-cols-1 gap-4">
                    <!-- Announcements -->
                    <section aria-labelledby="announcements-title">
                        <div class="overflow-hidden bg-white rounded-lg shadow">
                            <div class="p-6">
                                <h2
                                    id="announcements-title"
                                    class="text-base font-medium text-gray-900"
                                >
                                    Announcements
                                </h2>
                                <div class="flow-root mt-6">
                                    <h3
                                        v-if="announcements.length === 0"
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        No announcements
                                    </h3>
                                    <ul
                                        v-else
                                        role="list"
                                        class="-my-5 divide-y divide-gray-200"
                                    >
                                        <li
                                            v-for="announcement in announcements"
                                            :key="announcement"
                                            class="py-5"
                                        >
                                            <div class="relative focus-within:ring-2 focus-within:ring-cyan-500">
                                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                                    {{ announcement }}
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-6">
                                    <a
                                        href="#"
                                        class="flex justify-center items-center py-2 px-4 w-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 rounded-md border border-gray-300 shadow-sm"
                                    > View all </a>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Recent Hires -->
                    <section aria-labelledby="recent-hires-title">
                        <div class="overflow-hidden bg-white rounded-lg shadow">
                            <div class="p-6">
                                <h2
                                    id="recent-hires-title"
                                    class="text-base font-medium text-gray-900"
                                >
                                    Recent Hires
                                </h2>
                                <div class="flow-root mt-6">
                                    <ul
                                        role="list"
                                        class="-my-5 divide-y divide-gray-200"
                                    >
                                        <li class="py-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="shrink-0">
                                                    <img
                                                        class="w-8 h-8 rounded-full"
                                                        src="https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                        alt=""
                                                    >
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">
                                                        Leonard Krasner
                                                    </p>
                                                    <p class="text-sm text-gray-500 truncate">
                                                        @leonardkrasner
                                                    </p>
                                                </div>
                                                <div>
                                                    <a
                                                        href="#"
                                                        class="inline-flex items-center py-0.5 px-2.5 text-sm font-medium leading-5 text-gray-700 bg-white hover:bg-gray-50 rounded-full border border-gray-300 shadow-sm"
                                                    > View </a>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="py-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="shrink-0">
                                                    <img
                                                        class="w-8 h-8 rounded-full"
                                                        src="https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                        alt=""
                                                    >
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">
                                                        Floyd Miles
                                                    </p>
                                                    <p class="text-sm text-gray-500 truncate">
                                                        @floydmiles
                                                    </p>
                                                </div>
                                                <div>
                                                    <a
                                                        href="#"
                                                        class="inline-flex items-center py-0.5 px-2.5 text-sm font-medium leading-5 text-gray-700 bg-white hover:bg-gray-50 rounded-full border border-gray-300 shadow-sm"
                                                    > View </a>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="py-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="shrink-0">
                                                    <img
                                                        class="w-8 h-8 rounded-full"
                                                        src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                        alt=""
                                                    >
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">
                                                        Emily Selman
                                                    </p>
                                                    <p class="text-sm text-gray-500 truncate">
                                                        @emilyselman
                                                    </p>
                                                </div>
                                                <div>
                                                    <a
                                                        href="#"
                                                        class="inline-flex items-center py-0.5 px-2.5 text-sm font-medium leading-5 text-gray-700 bg-white hover:bg-gray-50 rounded-full border border-gray-300 shadow-sm"
                                                    > View </a>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="py-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="shrink-0">
                                                    <img
                                                        class="w-8 h-8 rounded-full"
                                                        src="https://images.unsplash.com/photo-1500917293891-ef795e70e1f6?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                        alt=""
                                                    >
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">
                                                        Kristin Watson
                                                    </p>
                                                    <p class="text-sm text-gray-500 truncate">
                                                        @kristinwatson
                                                    </p>
                                                </div>
                                                <div>
                                                    <a
                                                        href="#"
                                                        class="inline-flex items-center py-0.5 px-2.5 text-sm font-medium leading-5 text-gray-700 bg-white hover:bg-gray-50 rounded-full border border-gray-300 shadow-sm"
                                                    > View </a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-6">
                                    <a
                                        href="#"
                                        class="flex justify-center items-center py-2 px-4 w-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 rounded-md border border-gray-300 shadow-sm"
                                    > View all </a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</template>