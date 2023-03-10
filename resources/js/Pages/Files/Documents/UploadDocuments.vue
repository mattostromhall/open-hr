<script setup lang="ts">
import {useForm} from '@inertiajs/vue3'
import FileInput from '@/Components/Controls/FileInput.vue'
import FilePreview from '@/Components/FilePreview.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import type {Documentable, DocumentableType} from '../../../types'
import {computed} from 'vue'
import type {ComputedRef} from 'vue'

const props = defineProps<{
    path: string,
    documentable: Documentable
}>()

const emit = defineEmits(['uploaded'])

type DocumentsData = {
    path: string,
    documents?: File | File[],
    documentable_id: number,
    documentable_type: DocumentableType
}

const form = useForm<DocumentsData>({
    path: props.path,
    documents: undefined,
    documentable_id: props.documentable.id,
    documentable_type: props.documentable.type
})

const error: ComputedRef<string> = computed(() => {
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

function submit() {
    form.post('/documents', {
        onSuccess: () => {
            emit('uploaded')
            form.reset()
        }
    })
}
</script>

<template>
    <section>
        <div class="space-y-6 sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0">
            <form @submit.prevent="submit">
                <div class="shadow sm:rounded-md">
                    <div class="space-y-6 bg-white py-6 px-4 sm:rounded-t-md sm:p-6">
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Upload documents
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Select or drag and drop the documents you would like to upload, maximum 10 documents.
                            </p>
                        </div>
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6">
                                <FileInput
                                    input-id="upload"
                                    input-name="upload"
                                    :multiple="true"
                                    :error="error"
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
                    <div class="flex justify-end bg-gray-50 py-3 px-4 text-right sm:rounded-b-md sm:px-6">
                        <IndigoButton
                            :disabled="form.processing"
                        >
                            Upload
                        </IndigoButton>
                    </div>
                </div>
            </form>
        </div>
    </section>
</template>