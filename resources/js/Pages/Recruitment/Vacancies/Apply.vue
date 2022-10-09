<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import type {Vacancy} from '../../../types'
import type {Ref} from 'vue'
import {ref} from 'vue'

defineProps<{
    vacancy: Vacancy,
    contact: {
        name: string,
        email: string
    }
}>()

const active: Ref<'vacancy' | 'application'> = ref('vacancy')
</script>

<script lang="ts">
import Basic from '@/Layouts/Basic.vue'

export default {
    layout: Basic
}
</script>

<template>
    <section class="p-8">
        <div class="mb-6">
            <div class="sm:hidden">
                <label
                    for="tabs"
                    class="sr-only"
                >Select a tab</label>
                <select
                    id="tabs"
                    v-model="active"
                    name="tabs"
                    class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                >
                    <option
                        value="vacancy"
                        selected
                    >
                        Vacancy
                    </option>
                    <option value="application">
                        Application
                    </option>
                </select>
            </div>
            <div class="hidden sm:block">
                <nav
                    class="isolate flex divide-x divide-gray-200 rounded-lg shadow"
                    aria-label="Tabs"
                >
                    <button
                        type="button"
                        class="group relative min-w-0 flex-1 overflow-hidden rounded-l-lg bg-white p-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10"
                        :class="{
                            'text-gray-500 hover:text-gray-700': active !== 'vacancy',
                            'text-gray-900': active === 'vacancy'
                        }"
                        @click="active = 'vacancy'"
                    >
                        <span>Vacancy</span>
                        <span
                            v-show="active === 'vacancy'"
                            aria-hidden="true"
                            class="absolute inset-x-0 bottom-0 h-0.5 bg-blue-500"
                        />
                    </button>

                    <button
                        type="button"
                        class="group relative min-w-0 flex-1 overflow-hidden rounded-r-lg bg-white p-4 text-center text-sm font-medium hover:bg-gray-50 focus:z-10"
                        :class="{
                            'text-gray-500 hover:text-gray-700': active !== 'application',
                            'text-gray-900': active === 'application'
                        }"
                        @click="active = 'application'"
                    >
                        <span>Application</span>
                        <span
                            v-show="active === 'application'"
                            aria-hidden="true"
                            class="absolute inset-x-0 bottom-0 h-0.5 bg-blue-500"
                        />
                    </button>
                </nav>
            </div>
        </div>
        <div
            v-if="active === 'vacancy'"
            class="w-full max-w-4xl overflow-hidden bg-white shadow sm:rounded-lg"
        >
            <div class="px-4 py-5 sm:px-6">
                <h2 class="text-lg font-medium leading-6 text-gray-900">
                    Vacancy Information
                </h2>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Title
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ vacancy.title }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Contact
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <a
                                class="text-indigo-600"
                                :href="`mailto:${contact.email}`"
                            >{{ contact.name }} - {{ contact.email }}</a>
                        </dd>
                    </div>
                    <div
                        v-if="vacancy.contract_type"
                        class="sm:col-span-1"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Contract
                        </dt>
                        <dd class="mt-1 text-sm capitalize text-gray-900">
                            {{ vacancy.contract_type }} <span v-if="vacancy.contract_length">- {{ vacancy.contract_length }}</span>
                        </dd>
                    </div>
                    <div
                        v-if="vacancy.location"
                        class="sm:col-span-1"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Location
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ vacancy.location }}
                        </dd>
                    </div>
                    <div
                        v-if="vacancy.remuneration"
                        class="sm:col-span-1"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Remuneration
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ vacancy.remuneration }} {{ vacancy.remuneration_currency }}
                        </dd>
                    </div>
                    <div
                        v-if="vacancy.remuneration"
                        class="sm:col-span-1"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Closes
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ useDateFormat(vacancy.close_at, 'DD/MM/YYYY').value }}
                        </dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">
                            Description
                        </dt>
                        <dd class="mt-1">
                            <div
                                class="prose max-w-none"
                                v-html="vacancy.description"
                            />
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
</template>