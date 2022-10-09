<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import TabbedContent from '@/Components/TabbedContent.vue'
import type {ContractType, SelectOption, TabbedContentItem, Vacancy} from '../../../types'
import Post from './Post.vue'
import Open from './Open.vue'
import Closed from './Closed.vue'

defineProps<{
    active: TabbedContentItem['identifier'],
    contacts: SelectOption[],
    contractTypes: ContractType[],
    open: (Pick<Vacancy, 'id' | 'title' | 'location' | 'contract_type' | 'open_at' | 'close_at'>)[]
    closed: (Pick<Vacancy, 'id' | 'title' | 'location' | 'contract_type' | 'open_at' | 'close_at'>)[]
}>()

const tabs: TabbedContentItem[] = [
    {
        identifier: 'post',
        icon: 'ClockIcon',
        display: 'Post a Vacancy'
    },
    {
        identifier: 'open',
        icon: 'BookOpenIcon',
        display: 'Open Vacancies'
    },
    {
        identifier: 'closed',
        icon: 'LockClosedIcon',
        display: 'Closed Vacancies'
    }
]
</script>

<template>
    <Head>
        <title>Manage Vacancies</title>
    </Head>

    <PageHeading>
        Vacancies
        <template #link>
            <LightIndigoLink href="/dashboard/organisation">
                Dashboard
            </LightIndigoLink>
        </template>
    </PageHeading>
    <TabbedContent
        v-slot="{setActive, isActive}"
        :active="active"
        :tabs="tabs"
    >
        <Post
            v-if="isActive('post')"
            :contacts="contacts"
            :contract-types="contractTypes"
            @set-active="setActive"
        />
        <Open
            v-if="isActive('open')"
            :open="open"
            @set-active="setActive"
        />
        <Closed
            v-if="isActive('closed')"
            :closed="closed"
            @set-active="setActive"
        />
    </TabbedContent>
</template>