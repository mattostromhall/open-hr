<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import {IdentificationIcon, KeyIcon, MailIcon, UserGroupIcon} from '@heroicons/vue/outline'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import type {Department, Person} from '../../../types'
import Information from './Information.vue'
import PersonAddress from '../Profile/Address.vue'
import Access from './Access.vue'
import DirectReports from './DirectReports.vue'
import type {Address, Role, User} from '../../../types'

const props = defineProps<{
    user: Pick<User, 'id'|'email'|'active'>,
    person: Person,
    people: (Pick<Person, 'id'|'full_name'>)[],
    departments: Department[],
    address: Address,
    directReports: number[],
    roles: Role[],
    allRoles: Role[]
}>()

type ActiveTab = 'information'|'address'|'reports'|'access'

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
        <span class="font-normal">Editing - </span>{{ person.full_name }}
        <template #link>
            <LightIndigoLink :href="`/people/${person.id}`">
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
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('address'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('address')
                    }"
                    aria-current="page"
                    @click="setActive('address')"
                >
                    <MailIcon
                        class="shrink-0 mr-3 -ml-1 w-6 h-6"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('address'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('address')
                        }"
                    />
                    <span class="truncate">Address</span>
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
                <button
                    class="group flex items-center py-2 px-3 w-full text-sm font-medium rounded-md"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('access'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('access')
                    }"
                    @click="setActive('access')"
                >
                    <KeyIcon
                        class="shrink-0 mr-3 -ml-1 w-6 h-6"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('credentials'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('credentials')
                        }"
                    />
                    <span class="truncate">Manage Access</span>
                </button>
            </nav>
        </aside>
        <Information
            v-if="isActive('information')"
            :person="person"
            :people="people"
            :departments="departments"
        />
        <PersonAddress
            v-if="isActive('address')"
            :person="person"
            :address="address"
        />
        <DirectReports
            v-if="isActive('reports')"
            :person="person"
            :people="people"
            :direct-reports="directReports"
        />
        <Access
            v-if="isActive('access')"
            :user="user"
            :roles="roles"
            :all-roles="allRoles"
        />
    </div>
</template>