<script setup lang="ts">
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import {useForm} from '@inertiajs/inertia-vue3'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import EditorInput from '@/Components/Controls/EditorInput.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import FileInput from '@/Components/Controls/FileInput.vue'
import FilePreview from '@/Components/FilePreview.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import type {Application, Vacancy} from '../../../../types'

const props = defineProps<{
    vacancy: Vacancy,
}>()

type ApplicationData = Omit<Application, 'id'>
    & {
        id?: number,
        cv?: File
    }

const form: InertiaForm<ApplicationData> = useForm({
    id: undefined,
    vacancy_id: props.vacancy.id,
    name: '',
    contact_number: '',
    contact_email: '',
    cover_letter: undefined,
    cv: undefined
})

function submit() {
    form.post(`vacancies/${props.vacancy.id}/applications`)
}
</script>

<template>
    <div class="space-y-6 sm:w-full sm:max-w-4xl sm:px-6 lg:col-span-9 lg:px-0">
        <form @submit.prevent="submit">
            <div class="shadow sm:rounded-md">
                <div class="space-y-6 bg-white py-6 px-4 sm:rounded-t-md sm:p-6">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Application
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Please fill in the details below to apply.
                        </p>
                    </div>
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <FormLabel>Name <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <TextInput
                                    v-model="form.name"
                                    :error="form.errors.name"
                                    input-id="name"
                                    input-type="name"
                                    @reset="form.clearErrors('name')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Contact Number <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <TextInput
                                    v-model="form.contact_number"
                                    :error="form.errors.contact_number"
                                    input-id="contact_number"
                                    input-type="contact_number"
                                    @reset="form.clearErrors('contact_number')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Contact Email <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <TextInput
                                    v-model="form.contact_email"
                                    :error="form.errors.contact_email"
                                    input-id="contact_email"
                                    input-type="contact_email"
                                    @reset="form.clearErrors('contact_email')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6">
                            <FormLabel>Cover Letter (optional)</FormLabel>
                            <div class="mt-1">
                                <EditorInput
                                    v-model="form.cover_letter"
                                    :error="form.errors.cover_letter"
                                    :preview-enabled="true"
                                    @reset="form.clearErrors('cover_letter')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6">
                            <FormLabel>Curriculum Vitae <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <FileInput
                                    :error="form.errors.cv"
                                    input-id="cv"
                                    input-name="cv"
                                    @update:model-value="form.cv = $event"
                                    @reset="form.clearErrors('cv')"
                                />
                                <FilePreview
                                    class="mt-5"
                                    :file="form.cv"
                                    :name="form.cv?.name"
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