<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import {IdentificationIcon, UserGroupIcon} from '@heroicons/vue/outline'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import type {Department, Person} from '../../../types'
import Information from './Information.vue'
import DirectReports from './DirectReports.vue'

const props = defineProps<{
    person: Person,
    people: (Pick<Person, 'id'|'full_name'>)[],
    departments: Department[],
    directReports: number[]
}>()

type ActiveTab = 'information'|'reports'

const activeTab: Ref<ActiveTab> = ref('information')

function setActive(tab: ActiveTab): void {
    activeTab.value = tab
}

function isActive(tab: string): boolean {
    return activeTab.value === tab
}
</script>

<template>
    <Head :title="`Edit Person - ${person.full_name}`" />

    <PageHeading>
        {{ person.full_name }}
        <template #link>
            <LightIndigoLink href="/holidays/calendar">
                View
            </LightIndigoLink>
        </template>
    </PageHeading>
    <div class="p-8 lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:col-span-3 lg:p-0">
            <nav class="space-y-1">
                <button
                    class="group flex items-center py-2 px-3 w-full text-sm font-medium rounded-md"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('information'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('information')
                    }"
                    aria-current="page"
                    @click="setActive('information')"
                >
                    <IdentificationIcon
                        class="shrink-0 mr-3 -ml-1 w-6 h-6"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('information'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('information')
                        }"
                    />
                    <span class="truncate">Information</span>
                </button>
                <button
                    class="group flex items-center py-2 px-3 w-full text-sm font-medium rounded-md"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('reports'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('reports')
                    }"
                    @click="setActive('reports')"
                >
                    <UserGroupIcon
                        class="shrink-0 mr-3 -ml-1 w-6 h-6"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('reports'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('reports')
                        }"
                    />
                    <span class="truncate">Direct Reports</span>
                </button>
            </nav>
        </aside>
        <Information
            v-if="isActive('information')"
            :person="person"
            :people="people"
            :departments="departments"
        />
        <DirectReports
            v-if="isActive('reports')"
            :person="person"
            :people="people"
            :direct-reports="directReports"
        />
    </div>
</template>