<script setup lang="ts">
import {Head} from '@inertiajs/vue3'
import type {Breadcrumb, Department, SelectOption, TabbedContentItem} from '../../types'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import Members from './Members.vue'
import {ref} from 'vue'
import type {Ref} from 'vue'
import Information from './Information.vue'
import TabbedContent from '@/Components/TabbedContent.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import usePermissions from '../../Hooks/usePermissions'

const props = defineProps<{
    department: Department,
    members: number[],
    people: SelectOption[],
    headOptions: SelectOption[]
}>()

const {can} = usePermissions()

const breadcrumbs: Breadcrumb[] = [
    {
        link: '/departments',
        display: 'Departments'
    },
    {
        link: `/departments/${props.department.id}`,
        display: 'Department'
    }
]

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
            <LightIndigoLink
                v-if="can('view-document')"
                :href="`/departments/${department.id}`"
            >
                View
            </LightIndigoLink>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        dashboard="/dashboard/organisation"
        class="pt-8 px-8"
    />
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