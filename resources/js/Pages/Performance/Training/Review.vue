<script setup lang="ts">
import {Head, useForm} from '@inertiajs/vue3'
import type {InertiaForm} from '@inertiajs/vue3'
import type {Training, TrainingStatus} from '../../../types'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import TextAreaInput from '@/Components/Controls/TextAreaInput.vue'

const props = defineProps<{
    requester: string,
    training: Training,
    status: string
}>()

interface ReviewTrainingData {
    status: TrainingStatus,
    notes?: string
}

const form: InertiaForm<ReviewTrainingData> = useForm({
    status: props.training.status,
    notes: props.training.notes ?? undefined
})

function submit(): void {
    form.patch(`/training/${props.training.id}/review`)
}

function approve(): void {
    form.status = 2

    submit()
}

function reject(): void {
    form.status = 3

    submit()
}
</script>

<template>
    <Head>
        <title>Review Training Request</title>
    </Head>

    <section class="p-8">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="py-5 px-4 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Training requested by {{ requester }}
                </h3>
                <div class="mt-2 max-w-xl text-sm text-gray-500">
                    <p class="mt-1">
                        Description: {{ training.description }}
                    </p>
                    <p class="mt-1">
                        Provider: {{ training.provider }}
                    </p>
                    <p class="mt-1">
                        Cost: {{ training.cost ? `${training.cost_currency} ${training.cost}` : 'N/A' }}
                    </p>
                    <p class="mt-1">
                        Status: {{ status }}
                    </p>
                    <p
                        v-if="training.location"
                        class="mt-1"
                    >
                        Location: {{ training.location }}
                    </p>
                    <p
                        v-if="training.duration"
                        class="mt-1"
                    >
                        Duration: {{ training.duration }}
                    </p>
                    <p
                        v-if="training.notes"
                        class="mt-1"
                    >
                        Request notes: {{ training.notes }}
                    </p>
                </div>
                <div class="mt-3">
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
                <div class="mt-5 flex space-x-5">
                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-green-100 py-2 px-4 font-medium text-green-700 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:text-sm"
                        @click="approve"
                    >
                        Approve
                    </button>
                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-100 py-2 px-4 font-medium text-red-700 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:text-sm"
                        @click="reject"
                    >
                        Reject
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>