<script setup lang="ts">
import {Link} from '@inertiajs/inertia-vue3'
import {BackwardIcon, BellIcon, BookOpenIcon, ChartBarIcon, TagIcon, ClipboardDocumentListIcon} from '@heroicons/vue/24/outline'
</script>

<template>
    <section aria-labelledby="quick-links-title">
        <div class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-gray-200 shadow sm:grid sm:grid-cols-2 sm:gap-px sm:divide-y-0">
            <h2
                id="quick-links-title"
                class="sr-only"
            >
                Quick links
            </h2>

            <div class="group relative rounded-t-lg bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500 sm:rounded-tr-none">
                <div>
                    <span class="inline-flex rounded-lg bg-teal-50 p-3 text-teal-700 ring-4 ring-white">
                        <TagIcon class="h-6 w-6" />
                    </span>
                </div>
                <div class="mt-8">
                    <h3 class="text-lg font-medium">
                        <Link
                            href="/departments"
                            class="focus:outline-none"
                        >
                            <!-- Extend touch target to entire panel -->
                            <span
                                class="absolute inset-0"
                                aria-hidden="true"
                            />
                            Departments
                        </Link>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        View all the departments that are part of the Organisation.
                    </p>
                </div>
                <span
                    class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                    aria-hidden="true"
                >
                    <svg
                        class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                    </svg>
                </span>
            </div>

            <div class="group relative bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500 sm:rounded-tr-lg">
                <div>
                    <span class="inline-flex rounded-lg bg-purple-50 p-3 text-purple-700 ring-4 ring-white">
                        <BackwardIcon class="h-6 w-6" />
                    </span>
                </div>
                <div class="mt-8">
                    <h3 class="text-lg font-medium">
                        <Link
                            href="/logs"
                            class="focus:outline-none"
                        >
                            <!-- Extend touch target to entire panel -->
                            <span
                                class="absolute inset-0"
                                aria-hidden="true"
                            />
                            Action Logs
                        </Link>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        View the history of an entity by searching the Action Logs.
                    </p>
                </div>
                <span
                    class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                    aria-hidden="true"
                >
                    <svg
                        class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                    </svg>
                </span>
            </div>

            <div class="group relative bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                <div>
                    <span class="inline-flex rounded-lg bg-sky-50 p-3 text-sky-700 ring-4 ring-white">
                        <ClipboardDocumentListIcon class="h-6 w-6" />
                    </span>
                </div>
                <div class="mt-8">
                    <h3 class="text-lg font-medium">
                        <Link
                            href="/expense-types"
                            class="focus:outline-none"
                        >
                            <!-- Extend touch target to entire panel -->
                            <span
                                class="absolute inset-0"
                                aria-hidden="true"
                            />
                            Expense Types
                        </Link>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        View all Expense Types or add a new one.
                    </p>
                </div>
                <span
                    class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                    aria-hidden="true"
                >
                    <svg
                        class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                    </svg>
                </span>
            </div>

            <div class="group relative bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                <div>
                    <span class="inline-flex rounded-lg bg-yellow-50 p-3 text-yellow-700 ring-4 ring-white">
                        <ChartBarIcon class="h-6 w-6" />
                    </span>
                </div>
                <div class="mt-8">
                    <h3 class="text-lg font-medium">
                        <Link
                            href="/reports"
                            class="focus:outline-none"
                        >
                            <!-- Extend touch target to entire panel -->
                            <span
                                class="absolute inset-0"
                                aria-hidden="true"
                            />
                            Reports
                        </Link>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Generate or Save Reports on system data.
                    </p>
                </div>
                <span
                    class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                    aria-hidden="true"
                >
                    <svg
                        class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                    </svg>
                </span>
            </div>

            <div class="group relative bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500 sm:rounded-bl-lg">
                <div>
                    <span class="inline-flex rounded-lg bg-rose-50 p-3 text-rose-700 ring-4 ring-white">
                        <BellIcon class="h-6 w-6" />
                    </span>
                </div>
                <div class="mt-8">
                    <h3 class="text-lg font-medium">
                        <Link
                            href="/organisation/notifications/create"
                            class="focus:outline-none"
                        >
                            <!-- Extend touch target to entire panel -->
                            <span
                                class="absolute inset-0"
                                aria-hidden="true"
                            />
                            Notifications
                        </Link>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Create Notifications for your Organisation.
                    </p>
                </div>
                <span
                    class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                    aria-hidden="true"
                >
                    <svg
                        class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                    </svg>
                </span>
            </div>

            <div class="group relative rounded-b-lg bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500 sm:rounded-bl-none">
                <div>
                    <span class="inline-flex rounded-lg bg-indigo-50 p-3 text-indigo-700 ring-4 ring-white">
                        <BookOpenIcon class="h-6 w-6" />
                    </span>
                </div>
                <div class="mt-8">
                    <h3 class="text-lg font-medium">
                        <Link
                            href="/vacancies"
                            class="focus:outline-none"
                        >
                            <!-- Extend touch target to entire panel -->
                            <span
                                class="absolute inset-0"
                                aria-hidden="true"
                            />
                            Vacancies
                        </Link>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Manage the current Vacancies for your Organisation.
                    </p>
                </div>
                <span
                    class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
                    aria-hidden="true"
                >
                    <svg
                        class="h-6 w-6"
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
</template>