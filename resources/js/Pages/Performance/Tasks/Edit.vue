<script setup lang="ts">
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import DateInput from '@/Components/Controls/DateInput.vue'
import EditorInput from '@/Components/Controls/EditorInput.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import type {Task} from '../../../types'
import {useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'

const props = defineProps<{
    task: Task
}>()

const emit = defineEmits(['updated'])

type TaskData = Omit<Task, 'id' | 'days_remaining' | 'completed_at'>

const form: InertiaForm<TaskData> = useForm({
    objective_id: props.task.objective_id,
    description: props.task.description,
    due_at: props.task.due_at
})

function submit(): void {
    form.post(`/tasks/${props.task.id}`, {
        onSuccess: () => {
            emit('updated')
        }
    })
}
</script>

<template>
    <div class="mt-6 space-y-6 sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0">
        <form @submit.prevent="submit">
            <div class="shadow sm:rounded-md">
                <div class="space-y-6 bg-white py-6 px-4 sm:rounded-t-md sm:p-6">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Edit Task
                        </h3>
                    </div>
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6">
                            <FormLabel>Description <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <EditorInput v-model="form.description" />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Set a due date <RequiredIcon /></FormLabel>
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
                        Submit
                    </IndigoButton>
                </div>
            </div>
        </form>
    </div>
</template>