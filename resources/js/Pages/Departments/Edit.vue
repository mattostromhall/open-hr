<script setup lang="ts">
import {Head, useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import type {Department, Person, SelectOption} from '../../types'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import SearchableSelectInput from '@/Components/Controls/SearchableSelectInput.vue'
import Members from './Members.vue'

const props = defineProps<{
    department: Department,
    members: (Pick<Person, 'id' | 'first_name' | 'last_name' | 'full_name'>)[],
    nonMembers: SelectOption[],
    headOptions: SelectOption[]
}>()

type DepartmentData = Omit<Department, 'id'>

const form: InertiaForm<DepartmentData> = useForm({
    name: props.department.name,
    head_of_department_id: props.department.head_of_department_id
})
</script>

<template>
    <Head>
        <title>Edit Department</title>
    </Head>

    <PageHeading>
        Edit Department
        <template #link>
            <LightIndigoLink href="/departments">
                All Departments
            </LightIndigoLink>
        </template>
    </PageHeading>
    <div class="p-8 lg:grid lg:grid-cols-12 lg:gap-x-5">
        <div class="space-y-6 sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0">
            <form @submit.prevent="form.put(`/departments/${department.id}`)">
                <div class="shadow sm:rounded-md">
                    <div class="space-y-6 bg-white py-6 px-4 sm:rounded-t-md sm:p-6">
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Department Information
                            </h3>
                        </div>
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-4">
                                <FormLabel>Name <RequiredIcon /></FormLabel>
                                <div class="mt-1">
                                    <TextInput
                                        v-model="form.name"
                                        :error="form.errors.name"
                                        input-id="name"
                                        input-name="name"
                                        @reset="form.clearErrors('name')"
                                    />
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-4">
                                <FormLabel>Head of Department <RequiredIcon /></FormLabel>
                                <div class="mt-1">
                                    <SearchableSelectInput
                                        v-model="form.head_of_department_id"
                                        :error="form.errors.head_of_department_id"
                                        :options="headOptions"
                                        input-id="head_of_department_id"
                                        input-name="head_of_department_id"
                                        @reset="form.clearErrors('head_of_department_id')"
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
        <Members />
    </div>
</template>