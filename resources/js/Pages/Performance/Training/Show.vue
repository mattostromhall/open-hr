<script setup lang="ts">
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import {useDateFormat} from '@vueuse/core'
import type {Training} from '../../../types'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import {Head, useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import Tasks from '@/Pages/Performance/Objectives/Tasks.vue'

const props = defineProps<{
    training: Training
}>()

type TrainingStateData = Pick<Training, 'state'>

const form: InertiaForm<TrainingStateData> = useForm({
    state: props.training.state
})

function complete() {
    form.state = 3

    form.patch(`/training/${props.training.id}`)
}
</script>

<template>
    <Head>
        <title>View Training</title>
    </Head>

    <PageHeading>
        <span class="font-medium">Viewing</span> - {{ training.description }}
        <template #link>
            <div class="flex space-x-2">
                <LightIndigoLink :href="`/training/${training.id}/edit`">
                    Edit
                </LightIndigoLink>
                <LightIndigoLink href="/training">
                    Request Training
                </LightIndigoLink>
            </div>
        </template>
    </PageHeading>
    <section class="w-full p-8 sm:max-w-6xl">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="flex items-center justify-between py-5 px-4 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Training Information
                </h3>
                <form
                    v-if="training.status === 2 && training.state === 1"
                    @submit.prevent="complete"
                >
                    <IndigoButton>Start</IndigoButton>
                </form>
                <form
                    v-if="training.status === 2 && training.state === 2"
                    @submit.prevent="complete"
                >
                    <IndigoButton>Mark as complete</IndigoButton>
                </form>
            </div>
            <div class="border-t border-gray-200 py-5 px-4 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Title
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ objective.title }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Description
                        </dt>
                        <dd
                            class="prose mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                            v-html="objective.description"
                        />
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Status
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <p
                                class="inline-flex rounded-full px-2 text-xs font-semibold leading-5"
                                :class="{
                                    'bg-green-100 text-green-800': status(objective) === 'completed',
                                    'bg-blue-100 text-blue-800': status(objective) === 'current',
                                    'bg-red-100 text-red-800': status(objective) === 'overdue'
                                }"
                            >
                                {{ status(objective) === 'current' ? `${objective.days_remaining} days remaining` : status(objective) }}
                            </p>
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Due at
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ useDateFormat(objective.due_at, 'DD/MM/YYYY').value }}
                        </dd>
                    </div>
                    <div
                        v-if="objective.completed_at"
                        class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Completed at
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ useDateFormat(objective.completed_at, 'DD/MM/YYYY').value }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
        <Tasks
            class="mt-12"
            :objective="objective"
            :tasks="tasks"
        />
    </section>
</template>
