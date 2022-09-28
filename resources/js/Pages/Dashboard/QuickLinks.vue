<script setup lang="ts">
import {Link} from '@inertiajs/inertia-vue3'
import {ChartBarIcon, ClockIcon, DocumentTextIcon, UsersIcon} from '@heroicons/vue/24/outline'
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
                        <ClockIcon class="h-6 w-6" />
                    </span>
                </div>
                <div class="mt-8">
                    <h3 class="text-lg font-medium">
                        <Link
                            href="/holidays"
                            class="focus:outline-none"
                        >
                            <!-- Extend touch target to entire panel -->
                            <span
                                class="absolute inset-0"
                                aria-hidden="true"
                            />
                            Holiday
                        </Link>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Submit a holiday request for approval by your manager or view your already requested holidays.
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
                        <DocumentTextIcon class="h-6 w-6" />
                    </span>
                </div>
                <div class="mt-8">
                    <h3 class="text-lg font-medium">
                        <Link
                            href="/documents"
                            class="focus:outline-none"
                        >
                            <!-- Extend touch target to entire panel -->
                            <span
                                class="absolute inset-0"
                                aria-hidden="true"
                            />
                            Documents
                        </Link>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        View your organisation, department and personal documents.
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
                        <UsersIcon class="h-6 w-6" />
                    </span>
                </div>
                <div class="mt-8">
                    <h3 class="text-lg font-medium">
                        <Link
                            href="/performance"
                            class="focus:outline-none"
                        >
                            <!-- Extend touch target to entire panel -->
                            <span
                                class="absolute inset-0"
                                aria-hidden="true"
                            />
                            Performance
                        </Link>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Schedule one-to-ones or view your current objectives.
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
                        <a
                            href="#"
                            class="focus:outline-none"
                        >
                            <!-- Extend touch target to entire panel -->
                            <span
                                class="absolute inset-0"
                                aria-hidden="true"
                            />
                            Reports
                        </a>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Doloribus dolores nostrum quia qui natus officia quod et dolorem. Sit repellendus qui ut at blanditiis et quo et molestiae.
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
                        <!-- Heroicon name: outline/receipt-refund -->
                        <svg
                            class="h-6 w-6"
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
                        <Link
                            href="/expenses"
                            class="focus:outline-none"
                        >
                            <!-- Extend touch target to entire panel -->
                            <span
                                class="absolute inset-0"
                                aria-hidden="true"
                            />
                            Submit an expense
                        </Link>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Submit an expense and track the status of your submitted expenses.
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
                        <!-- Heroicon name: outline/academic-cap -->
                        <svg
                            class="h-6 w-6"
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
                        <Link
                            href="/training"
                            class="focus:outline-none"
                        >
                            <!-- Extend touch target to entire panel -->
                            <span
                                class="absolute inset-0"
                                aria-hidden="true"
                            />
                            Training
                        </Link>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Submit a training request for approval by your manager or view your already requested training.
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