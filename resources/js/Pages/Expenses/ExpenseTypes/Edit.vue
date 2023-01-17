<script setup lang="ts">
import {Head, useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import type {Breadcrumb, ExpenseType} from '../../../types'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import usePermissions from '../../../Hooks/usePermissions'

const props = defineProps<{
    expenseType: ExpenseType
}>()

const {can} = usePermissions()

const breadcrumbs: Breadcrumb[] = [
    {
        link: '/expense-types',
        display: 'Expense Types'
    },
    {
        display: 'Expense Type'
    }
]

const form: InertiaForm<{type: string}> = useForm({
    type: props.expenseType.type
})
</script>

<template>
    <Head>
        <title>Edit Expense Type</title>
    </Head>

    <PageHeading>
        Edit Expense Type
        <template #link>
            <LightIndigoLink
                v-if="can('view-expense-types')"
                href="/expense-types"
            >
                All Expense Types
            </LightIndigoLink>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        dashboard="/dashboard/organisation"
        class="pt-8 px-8"
    />
    <div class="p-8 lg:grid lg:grid-cols-12 lg:gap-x-5">
        <div class="space-y-6 sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0">
            <form @submit.prevent="form.put(`/expense-types/${expenseType.id}`)">
                <div class="shadow sm:rounded-md">
                    <div class="space-y-6 bg-white py-6 px-4 sm:rounded-t-md sm:p-6">
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Expense Type Information
                            </h3>
                        </div>
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-4">
                                <FormLabel>Type <RequiredIcon /></FormLabel>
                                <div class="mt-1">
                                    <TextInput
                                        v-model="form.type"
                                        :error="form.errors.type"
                                        input-id="type"
                                        input-type="type"
                                        @reset="form.clearErrors('type')"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end bg-gray-50 py-3 px-4 text-right sm:rounded-b-md sm:px-6">
                        <IndigoButton
                            :disabled="form.processing"
                        >
                            Submit
                        </IndigoButton>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>