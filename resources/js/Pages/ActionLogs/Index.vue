<script setup lang="ts">
import type {Breadcrumb} from '../../types'
import {Head} from '@inertiajs/vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import SearchableSelectInput from '@/Components/Controls/SearchableSelectInput.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import NumberInput from '../../Components/Controls/NumberInput.vue'
import type {Ref} from 'vue'
import {ref} from 'vue'
import IndigoLink from '../../Components/Controls/IndigoLink.vue'
import usePermissions from '../../Hooks/usePermissions'

const {isAn} = usePermissions()

const breadcrumbs: Breadcrumb[] = [
    {
        display: 'Logs'
    }
]

const options: string[] = [
    'address',
    'application',
    'department',
    'document',
    'expense-type',
    'expense',
    'holiday',
    'objective',
    'people',
    'sickness',
    'task',
    'training',
    'user',
    'vacancy'
]

const type: Ref<string> = ref('')
const id: Ref<number> = ref(1)
</script>

<template>
    <Head>
        <title>Action Logs</title>
    </Head>
    <PageHeading>
        Action Logs
        <template #link>
            <LightIndigoLink
                v-if="isAn('admin')"
                href="/organisation/dashboard"
            >
                Dashboard
            </LightIndigoLink>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        dashboard="/dashboard/organisation"
        class="pt-8 px-8"
    />
    <section class="p-8 space-y-6 sm:w-full sm:max-w-3xl lg:col-span-9">
        <div class="p-8 shadow sm:rounded-md bg-white">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-3">
                    <FormLabel>Select a record type to view logs for <RequiredIcon /></FormLabel>
                    <div class="mt-1">
                        <SearchableSelectInput
                            v-model="type"
                            :options="options"
                        />
                    </div>
                </div>
                <div class="col-span-3">
                    <FormLabel>Enter the ID for the record <RequiredIcon /></FormLabel>
                    <div class="mt-1">
                        <NumberInput v-model="id" />
                    </div>
                </div>
                <div class="col-span-6 flex justify-end">
                    <IndigoLink
                        v-if="type && id"
                        :href="`/logs/${type}/${id}`"
                    >
                        Go
                    </IndigoLink>
                </div>
            </div>
        </div>
    </section>
</template>