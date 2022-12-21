<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import {KeyIcon, EnvelopeIcon, UserCircleIcon} from '@heroicons/vue/24/outline'
import {Head} from '@inertiajs/inertia-vue3'
import PersonalInformation from './PersonalInformation.vue'
import Credentials from './Credentials.vue'
import PersonAddress from './Address.vue'
import PageHeading from '@/Components/PageHeading.vue'
import type {Address, Breadcrumb, Person, User} from '../../../types'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'

const props = defineProps<{
    active: string,
    user: Pick<User, 'id' | 'email'>,
    person: Pick<Person, 'id' | 'full_name' | 'title' | 'first_name' | 'last_name' | 'initials' | 'pronouns' | 'dob' | 'contact_number' | 'contact_email'>,
    address: Address
}>()

const breadcrumbs: Breadcrumb[] = [
    {
        display: 'Profile'
    },
    {
        display: props.person.full_name
    }
]

const activeTab: Ref<string> = ref(props.active)

function setActive(tab: string): void {
    activeTab.value = tab
}

function isActive(tab: string): boolean {
    return activeTab.value === tab
}
</script>

<template>
    <Head>
        <title>Profile</title>
    </Head>

    <PageHeading>Profile</PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        class="pt-8 px-8"
    />
    <div class="p-8 lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:col-span-3 lg:p-0">
            <nav class="space-y-1">
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('personal'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('personal')
                    }"
                    aria-current="page"
                    @click="setActive('personal')"
                >
                    <UserCircleIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('personal'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('personal')
                        }"
                    />
                    <span class="truncate">Personal Information</span>
                </button>
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('address'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('address')
                    }"
                    aria-current="page"
                    @click="setActive('address')"
                >
                    <EnvelopeIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('address'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('address')
                        }"
                    />
                    <span class="truncate">Address</span>
                </button>
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('credentials'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('credentials')
                    }"
                    @click="setActive('credentials')"
                >
                    <KeyIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('credentials'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('credentials')
                        }"
                    />
                    <span class="truncate">Credentials</span>
                </button>
            </nav>
        </aside>
        <PersonalInformation
            v-if="isActive('personal')"
            :person="person"
        />
        <PersonAddress
            v-if="isActive('address')"
            :person="person"
            :address="address"
        />
        <Credentials
            v-if="isActive('credentials')"
            :user="user"
        />
    </div>
</template>