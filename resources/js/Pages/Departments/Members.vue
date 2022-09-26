<script setup lang="ts">
import {useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import type {Department, SelectOption} from '../../types'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import MultiSelectInput from '@/Components/Controls/MultiSelectInput.vue'

const props = defineProps<{
    department: Department,
    members: number[],
    people: SelectOption[]
}>()

interface MemberData {
    members: number[]
}

const form: InertiaForm<MemberData> = useForm({
    members: props.members
})

function submit(): void {
    form.post(`/departments/${props.department.id}/members`)
}
</script>

<template>
    <div class="space-y-6 sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0">
        <form @submit.prevent="submit">
            <div class="shadow sm:rounded-md">
                <div class="space-y-6 bg-white py-6 px-4 sm:rounded-t-md sm:p-6">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Members
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Manage who is a member of {{ department.name }}
                        </p>
                    </div>
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            <FormLabel>Reports <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <MultiSelectInput
                                    v-model="form.members"
                                    :error="form.errors.members"
                                    :options="people"
                                    input-id="members"
                                    input-name="members"
                                    @reset="form.clearErrors('members')"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end bg-gray-50 py-3 px-4 text-right sm:rounded-b-md sm:px-6">
                    <IndigoButton
                        :disabled="form.processing"
                    >
                        Save
                    </IndigoButton>
                </div>
            </div>
        </form>
    </div>
</template>