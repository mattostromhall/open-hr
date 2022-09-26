<script setup lang="ts">
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import {Head} from '@inertiajs/inertia-vue3'
import type {Department, Person} from '../../types'
import type {ComputedRef} from 'vue'
import {computed} from 'vue'

const props = defineProps<{
    department: Department,
    head: Pick<Person, 'id' | 'first_name' | 'last_name' | 'full_name'>,
    members: (Pick<Person, 'id' | 'first_name' | 'last_name' | 'full_name'>)[]
}>()

const size: ComputedRef<number> = computed(() => props.members.length)
</script>

<template>
    <Head>
        <title>View Department</title>
    </Head>

    <PageHeading>
        <span class="font-medium">Viewing</span> - {{ department.name }}
        <template #link>
            <div class="flex space-x-2">
                <LightIndigoLink :href="`/departments/${department.id}/edit`">
                    Edit
                </LightIndigoLink>
            </div>
        </template>
    </PageHeading>
    <section class="w-full p-8 sm:max-w-6xl">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="flex items-center justify-between py-5 px-4 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    {{ department.name }}
                </h3>
            </div>
            <div class="border-t border-gray-200 py-5 px-4 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Head of Department
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ head.full_name }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Size
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ size === 1 ? `${size} member` : `${size} members` }}
                        </dd>
                    </div>
                    <div
                        v-if="members.length > 0"
                        class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Members
                        </dt>
                        <dd class="mt-1 space-x-1 space-y-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <span
                                v-for="{full_name} in members"
                                :key="full_name"
                                class="inline-flex rounded-full bg-indigo-100 px-2 text-xs font-semibold leading-5 text-indigo-800"
                            >
                                {{ full_name }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
</template>
