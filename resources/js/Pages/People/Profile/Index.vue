<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import {KeyIcon, MailIcon, UserCircleIcon} from '@heroicons/vue/outline'
import {Head} from '@inertiajs/inertia-vue3'
import PersonalInformation from './PersonalInformation.vue'
import Credentials from './Credentials.vue'
import Address from './Address.vue'
import PageHeading from '@/Components/PageHeading.vue'

defineProps({
    email: {
        type: String,
        default: ''
    },
    person: {
        type: Object,
        required: true
    },
    address: {
        type: Object,
        default: () => {
            return {}
        }
    }
})

const activeTab: Ref<string> = ref('personal')

function setActive(tab: string): void {
    activeTab.value = tab
}

function isActive(tab: string): boolean {
    return activeTab.value === tab
}
</script>

<template>
    <Head title="Profile" />

    <PageHeading>Profile</PageHeading>
    <div class="p-8 lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:col-span-3 lg:p-0">
            <nav class="space-y-1">
                <button
                    class="group flex items-center py-2 px-3 w-full text-sm font-medium rounded-md"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('personal'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('personal')
                    }"
                    aria-current="page"
                    @click="setActive('personal')"
                >
                    <UserCircleIcon
                        class="shrink-0 mr-3 -ml-1 w-6 h-6"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('personal'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('personal')
                        }"
                    />
                    <span class="truncate">Personal Information</span>
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
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('credentials'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('credentials')
                    }"
                    @click="setActive('credentials')"
                >
                    <KeyIcon
                        class="shrink-0 mr-3 -ml-1 w-6 h-6"
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
        <Address
            v-if="isActive('address')"
            :person="person"
            :address="address"
        />
        <Credentials
            v-if="isActive('credentials')"
            :email="email"
        />
    </div>
</template>