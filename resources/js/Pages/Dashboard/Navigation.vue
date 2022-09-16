<script setup lang="ts">
import {Link} from '@inertiajs/inertia-vue3'
import {Inertia} from '@inertiajs/inertia'

function select(event: Event) {
    return Inertia.visit(`/dashboard${(event.target as HTMLSelectElement).value}`)
}
</script>

<template>
    <div>
        <div class="sm:hidden">
            <label
                for="tabs"
                class="sr-only"
            >Select a tab</label>
            <select
                id="tabs"
                name="tabs"
                class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                @change="select"
            >
                <option
                    value=""
                    :selected="$page.url === '/dashboard'"
                >
                    Personal
                </option>

                <option
                    value="/management"
                    :selected="$page.url === '/dashboard/management'"
                >
                    Management
                </option>

                <option
                    value="/department"
                    :selected="$page.url === '/dashboard/department'"
                >
                    Department
                </option>

                <option
                    value="/organisation"
                    :selected="$page.url === '/dashboard/organisation'"
                >
                    Organisation
                </option>
            </select>
        </div>
        <div class="hidden sm:block">
            <nav
                class="isolate flex divide-x divide-gray-200 rounded-lg shadow"
                aria-label="Tabs"
            >
                <Link
                    href="/dashboard"
                    class="group relative min-w-0 flex-1 overflow-hidden rounded-l-lg bg-white p-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10"
                    :class="{
                        'text-gray-500 hover:text-gray-700': $page.url !== '/dashboard',
                        'text-gray-900': $page.url === '/dashboard'
                    }"
                >
                    <span>Personal</span>
                    <span
                        v-show="$page.url === '/dashboard'"
                        aria-hidden="true"
                        class="absolute inset-x-0 bottom-0 h-0.5 bg-indigo-500"
                    />
                </Link>
                <Link
                    href="/dashboard/management"
                    class="group relative min-w-0 flex-1 overflow-hidden bg-white p-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10"
                    :class="{
                        'text-gray-500 hover:text-gray-700': $page.url !== '/dashboard/management',
                        'text-gray-900': $page.url === '/dashboard/management'
                    }"
                >
                    <span>Management</span>
                    <span
                        v-show="$page.url === '/dashboard/management'"
                        aria-hidden="true"
                        class="absolute inset-x-0 bottom-0 h-0.5 bg-indigo-500"
                    />
                </Link>
                <Link
                    href="/dashboard/department"
                    class="group relative min-w-0 flex-1 overflow-hidden bg-white p-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10"
                    :class="{
                        'text-gray-500 hover:text-gray-700': $page.url !== '/dashboard/department',
                        'text-gray-900': $page.url === '/dashboard/department'
                    }"
                >
                    <span>Department</span>
                    <span
                        v-show="$page.url === '/dashboard/department'"
                        aria-hidden="true"
                        class="absolute inset-x-0 bottom-0 h-0.5 bg-indigo-500"
                    />
                </Link>
                <Link
                    href="/dashboard/organisation"
                    class="group relative min-w-0 flex-1 overflow-hidden rounded-r-lg bg-white p-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10"
                    :class="{
                        'text-gray-500 hover:text-gray-700': $page.url !== '/dashboard/organisation',
                        'text-gray-900': $page.url === '/dashboard/organisation'
                    }"
                >
                    <span>Organisation</span>
                    <span
                        v-show="$page.url === '/dashboard/organisation'"
                        aria-hidden="true"
                        class="absolute inset-x-0 bottom-0 h-0.5 bg-indigo-500"
                    />
                </Link>
            </nav>
        </div>
    </div>
</template>