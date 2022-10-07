<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import TabbedContent from '@/Components/TabbedContent.vue'
import type {ContractType, SelectOption, TabbedContentItem} from '../../../types'
import Post from './Post.vue'

defineProps<{
    active: TabbedContentItem['identifier'],
    contacts: SelectOption[],
    contractTypes: ContractType[]
}>()

const tabs: TabbedContentItem[] = [
    {
        identifier: 'post',
        icon: 'ClockIcon',
        display: 'Post a Vacancy'
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
    </TabbedContent>
</template>