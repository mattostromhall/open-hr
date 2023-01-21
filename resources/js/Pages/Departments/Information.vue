<script setup lang="ts">
import FormLabel from '@/Components/Controls/FormLabel.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import SearchableSelectInput from '@/Components/Controls/SearchableSelectInput.vue'
import type {Department, SelectOption} from '../../types'
import {useForm} from '@inertiajs/vue3'

const props = defineProps<{
    department: Department,
    headOptions: SelectOption[]
}>()

type DepartmentData = Omit<Department, 'id'>

const form = useForm<DepartmentData>({
    name: props.department.name,
    head_of_department_id: props.department.head_of_department_id
})

function submit() {
    form.put(`/departments/${props.department.id}`)
}
</script>

<template>
    <div class="space-y-6 sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0">
        <form @submit.prevent="submit">
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
</template>