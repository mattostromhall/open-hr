<script setup lang="ts">
import EditorInput from '@/Components/Controls/EditorInput.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import DateInput from '@/Components/Controls/DateInput.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import {useForm} from '@inertiajs/inertia-vue3'
import type {Objective, Person} from '../../../types'

const props = defineProps<{
    objective: Objective,
    person: Pick<Person, 'first_name' | 'last_name' | 'full_name'>
}>()

type ObjectiveData = Omit<Objective, 'id' | 'person_id' | 'days_remaining' | 'completed_at'>

const form: InertiaForm<ObjectiveData> = useForm({
    title: props.objective.title,
    description: props.objective.description,
    due_at: props.objective.due_at
})

function submit(): void {
    form.put(`/objectives/${props.objective.id}`)
}
</script>

<template>
    <Head>
        <title>Edit Objective</title>
    </Head>

    <PageHeading>
        <span class="font-medium">Editing</span> - {{ objective.title }}
        <template #link>
            <LightIndigoLink :href="`/objectives/${objective.id}`">
                View
            </LightIndigoLink>
        </template>
    </PageHeading>
    <div class="space-y-6 p-8 sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9">
        <form @submit.prevent="submit">
            <div class="shadow sm:rounded-md">
                <div class="space-y-6 bg-white py-6 px-4 sm:rounded-t-md sm:p-6">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Update Objective
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Update the objective for {{ person.full_name }}
                        </p>
                    </div>
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <FormLabel>Title</FormLabel>
                            <div class="mt-1">
                                <TextInput
                                    v-model="form.title"
                                    :error="form.errors.title"
                                    input-id="title"
                                    input-name="title"
                                    @reset="form.clearErrors('title')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6">
                            <FormLabel>Description <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <EditorInput
                                    v-model="form.description"
                                    :error="form.errors.description"
                                    @reset="form.clearErrors('description')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Due date <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <DateInput
                                    v-model="form.due_at"
                                    :error="form.errors.due_at"
                                    input-id="due_at"
                                    input-name="due_at"
                                    @reset="form.clearErrors('due_at')"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end bg-gray-50 py-3 px-4 text-right sm:rounded-b-md sm:px-6">
                    <IndigoButton
                        :disabled="form.processing"
                    >
                        Update
                    </IndigoButton>
                </div>
            </div>
        </form>
    </div>
</template>