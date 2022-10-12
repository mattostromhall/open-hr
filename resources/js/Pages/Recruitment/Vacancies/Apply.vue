<script setup lang="ts">
import type {Vacancy} from '../../../types'
import {Head} from '@inertiajs/inertia-vue3'
import type {Ref} from 'vue'
import {ref} from 'vue'
import Specification from './Specification.vue'
import Submit from '../Applications/Submit.vue'

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
    <Head>
        <title>Vacancy | {{ vacancy.title }}</title>
    </Head>
    <section class="mx-auto flex min-h-screen flex-1 flex-col items-center p-8">
        <div class="mb-6 w-full max-w-4xl">
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
        <Specification
            v-if="active === 'vacancy'"
            :vacancy="vacancy"
            :contact="contact"
        />
        <Submit
            v-if="active === 'application'"
            :vacancy="vacancy"
        />
    </section>
</template>