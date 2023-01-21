<script setup lang="ts">
import {useForm} from '@inertiajs/vue3'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import DateInput from '@/Components/Controls/DateInput.vue'
import TextAreaInput from '@/Components/Controls/TextAreaInput.vue'
import FileInput from '@/Components/Controls/FileInput.vue'
import FilePreview from '@/Components/FilePreview.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import type {Breadcrumb, Sickness} from '../../../types'
import {computed} from 'vue'
import type {ComputedRef} from 'vue'
import {Head} from '@inertiajs/vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import usePermissions from '../../../Hooks/usePermissions'

const props = defineProps<{
    sickness: Sickness,
    logger: string
}>()

const {can} = usePermissions()

const breadcrumbs: Breadcrumb[] = [
    {
        link: '/sicknesses',
        display: 'Sick Days'
    },
    {
        link: `/sicknesses/${props.sickness.id}`,
        display: 'Sick Day'
    }
]

type LogSicknessData = Omit<Sickness, 'id' | 'person_id'>
    &
    {
        _method: 'put',
        documents?: File | File[]
    }

const form = useForm<LogSicknessData>({
    _method: 'put',
    start_at: props.sickness.start_at,
    finish_at: props.sickness.finish_at,
    notes: props.sickness.notes,
    documents: undefined
})

const documentError: ComputedRef<string> = computed(() => {
    let message = ''

    Object.entries(form.errors).find(([key, value]) => {
        if (key.startsWith('documents')) {
            message = value
            return true
        }

        return false
    })

    return message
})

function submit(): void {
    form.post(`/sicknesses/${props.sickness.id}`)
}
</script>

<template>
    <Head>
        <title>Edit Sickness</title>
    </Head>

    <PageHeading>
        <span class="font-medium">Editing</span> - Sickness logged by {{ logger }}
        <template #link>
            <LightIndigoLink
                v-if="can('view-sickness')"
                :href="`/sicknesses/${sickness.id}`"
            >
                View
            </LightIndigoLink>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        class="pt-8 px-8"
    />
    <div class="space-y-6 p-8 sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9">
        <form @submit.prevent="submit">
            <div class="shadow sm:rounded-md">
                <div class="space-y-6 bg-white py-6 px-4 sm:rounded-t-md sm:p-6">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Update Sick Day/Days
                        </h3>
                    </div>
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <FormLabel>Start at <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <DateInput
                                    v-model="form.start_at"
                                    :error="form.errors.start_at"
                                    input-id="start_at"
                                    input-name="start_at"
                                    @reset="form.clearErrors('start_at')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <FormLabel>Finish at</FormLabel>
                            <div class="mt-1">
                                <DateInput
                                    v-model="form.finish_at"
                                    :error="form.errors.finish_at"
                                    input-id="finish_at"
                                    input-name="finish_at"
                                    @reset="form.clearErrors('finish_at')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6">
                            <FormLabel>Notes</FormLabel>
                            <div class="mt-1">
                                <TextAreaInput
                                    v-model="form.notes"
                                    :error="form.errors.notes"
                                    input-id="notes"
                                    input-name="notes"
                                    @reset="form.clearErrors('notes')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6">
                            <FormLabel>Documents</FormLabel>
                            <div class="mt-1">
                                <FileInput
                                    :error="documentError"
                                    input-id="documents"
                                    input-name="documents"
                                    :multiple="true"
                                    @update:model-value="form.documents = $event"
                                    @reset="form.clearErrors()"
                                />
                                <FilePreview
                                    v-for="(document, index) in form.documents"
                                    :key="index"
                                    class="mt-5"
                                    :file="document"
                                    :name="document?.name"
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