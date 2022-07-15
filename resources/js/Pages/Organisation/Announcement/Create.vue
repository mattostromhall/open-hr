<script setup lang="ts">
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
</script>

<template>
    <Head title="Organisation Announcements" />

    <PageHeading>
        Create Announcement
        <template #link>
            <LightIndigoLink href="/organisation/announcements">
                View all
            </LightIndigoLink>
        </template>
    </PageHeading>

    <section class="p-8">
        Form here
    </section>
</template>