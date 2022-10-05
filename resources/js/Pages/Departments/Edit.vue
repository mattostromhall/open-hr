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
import type {TabbedContentItem} from '../../types'
import TabbedContent from '@/Components/TabbedContent.vue'

defineProps<{
    department: Department,
    members: number[],
    people: SelectOption[],
    headOptions: SelectOption[]
}>()

type ActiveTab = 'information' | 'members'

const active: Ref<ActiveTab> = ref('information')

const tabs: TabbedContentItem[] = [
    {
        identifier: 'information',
        icon: 'InformationCircleIcon',
        display: 'Information'
    },
    {
        identifier: 'members',
        icon: 'UserGroupIcon',
        display: 'Members'
    }
]
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
    <TabbedContent
        v-slot="{isActive}"
        :tabs="tabs"
        :active="active"
    >
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
    </TabbedContent>
</template>