<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import TabbedContent from '../../../Components/TabbedContent.vue'
import type {TabbedContentItem} from '../../../types'

defineProps<{
    active: TabbedContentItem['identifier']
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
        :active="active"
        :tabs="tabs"
    >
        //
    </TabbedContent>
</template>