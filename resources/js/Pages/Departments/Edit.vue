<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import type {Department, SelectOption} from '../../types'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import Members from './Members.vue'
import {ref} from 'vue'
import type {Ref} from 'vue'
import {InformationCircleIcon, UserGroupIcon} from '@heroicons/vue/24/outline'
import Information from './Information.vue'

defineProps<{
    department: Department,
    members: number[],
    people: SelectOption[],
    headOptions: SelectOption[]
}>()

type ActiveTab = 'information' | 'members'

const activeTab: Ref<ActiveTab> = ref('information')

function setActive(tab: ActiveTab): void {
    activeTab.value = tab
}

function isActive(tab: string): boolean {
    return activeTab.value === tab
}
</script>

<template>
    <Head>
        <title>Edit Department</title>
    </Head>

    <PageHeading>
        Edit Department
        <template #link>
            <LightIndigoLink :href="`/departments/${department.id}`">
                View
            </LightIndigoLink>
        </template>
    </PageHeading>
    <div class="p-8 lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:col-span-3 lg:p-0">
            <nav class="space-y-1">
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('information'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('information')
                    }"
                    aria-current="page"
                    @click="setActive('information')"
                >
                    <InformationCircleIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('information'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('information')
                        }"
                    />
                    <span class="truncate">Information</span>
                </button>
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('members'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('members')
                    }"
                    aria-current="page"
                    @click="setActive('members')"
                >
                    <UserGroupIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('members'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('members')
                        }"
                    />
                    <span class="truncate">Members</span>
                </button>
            </nav>
        </aside>
        <Information
            v-if="isActive('information')"
            :department="department"
            :head-options="headOptions"
        />
        <Members
            v-if="isActive('members')"
            :department="department"
            :members="members"
            :people="people"
        />
    </div>
</template>