<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import type {Department, Person} from '../../../types'
import Information from './Information.vue'
import PersonAddress from '../Profile/Address.vue'
import Access from './Access.vue'
import DirectReports from './DirectReports.vue'
import type {Address, Role, User} from '../../../types'
import type {TabbedContentItem} from '../../../types'
import TabbedContent from '@/Components/TabbedContent.vue'

defineProps<{
    user: Pick<User, 'id'|'email'|'active'>,
    person: Person,
    people: (Pick<Person, 'id'|'full_name'>)[],
    departments: Department[],
    address: Address,
    directReports: number[],
    roles: Role[],
    allRoles: Role[]
}>()

type ActiveTab = 'information' | 'address' | 'reports'  |'access'

const active: Ref<ActiveTab> = ref('information')

const tabs: TabbedContentItem[] = [
    {
        identifier: 'information',
        icon: 'IdentificationIcon',
        display: 'Information'
    },
    {
        identifier: 'address',
        icon: 'EnvelopeIcon',
        display: 'Address'
    },
    {
        identifier: 'reports',
        icon: 'UserGroupIcon',
        display: 'Direct Reports'
    },
    {
        identifier: 'access',
        icon: 'KeyIcon',
        display: 'Manage Access'
    }
]
</script>

<template>
    <Head>
        <title>Edit Person - {{ person.full_name }}</title>
    </Head>

    <PageHeading>
        <span class="font-normal">Editing - </span>{{ person.full_name }}
        <template #link>
            <LightIndigoLink :href="`/people/${person.id}`">
                View
            </LightIndigoLink>
        </template>
    </PageHeading>
    <TabbedContent
        v-slot="{isActive}"
        :tabs="tabs"
        :active="active"
    >
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
    </TabbedContent>
</template>