<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
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
    <div class="p-8 lg:grid lg:grid-cols-12 lg:gap-x-5">
        Vacancies
    </div>
</template>