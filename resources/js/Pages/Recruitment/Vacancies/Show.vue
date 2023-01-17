<script setup lang="ts">
import type {Application, Paginated, TabbedContentItem, Vacancy} from '../../../types'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import TabbedContent from '@/Components/TabbedContent.vue'
import Overview from './Overview.vue'
import Applications from './Applications.vue'
import type {Breadcrumb, Person} from '../../../types'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import usePermissions from '../../../Hooks/usePermissions'

const props = defineProps<{
    active: TabbedContentItem['identifier'],
    vacancy: Vacancy,
    contact: Pick<Person, 'id' | 'full_name'>,
    applications: Paginated<Omit<Application, 'cover_letter'>>
}>()

const {can} = usePermissions()

const breadcrumbs: Breadcrumb[] = [
    {
        link: '/vacancies?active=open',
        display: 'Vacancies'
    },
    {
        display: props.vacancy.title
    }
]

const tabs: TabbedContentItem[] = [
    {
        identifier: 'overview',
        icon: 'InformationCircleIcon',
        display: 'Overview'
    },
    {
        identifier: 'applications',
        icon: 'EnvelopeIcon',
        display: 'Applications'
    },
]
</script>

<template>
    <Head>
        <title>View Vacancy</title>
    </Head>

    <PageHeading>
        Viewing - {{ vacancy.title }}
        <template #link>
            <div class="flex space-x-2">
                <LightIndigoLink
                    v-if="can('update-vacancy')"
                    :href="`/vacancies/${vacancy.id}/edit`"
                >
                    Edit
                </LightIndigoLink>
                <LightIndigoLink
                    v-if="can('view-vacancies')"
                    href="/vacancies"
                >
                    All Vacancies
                </LightIndigoLink>
            </div>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        dashboard="/dashboard/organisation"
        class="pt-8 px-8"
    />
    <TabbedContent
        v-slot="{isActive}"
        :active="active"
        :tabs="tabs"
    >
        <Overview
            v-if="isActive('overview')"
            :vacancy="vacancy"
            :contact="contact"
        />
        <Applications
            v-if="isActive('applications')"
            :applications="applications"
        />
    </TabbedContent>
</template>