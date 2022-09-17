<script setup lang="ts">
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import type {Training} from '../../../types'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import {Head, useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import type {Person} from '../../../types'

const props = defineProps<{
    training: Training,
    status: string,
    state: string,
    person: Pick<Person, 'first_name' | 'last_name' | 'full_name'>
}>()

type TrainingStateData = Pick<Training, 'status' | 'state'>

const form: InertiaForm<TrainingStateData> = useForm({
    status: props.training.status,
    state: props.training.state
})

function start() {
    form.status = 2

    form.post(`/training/${props.training.id}/start`)
}

function complete() {
    form.state = 3

    form.post(`/training/${props.training.id}/complete`)
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
                    Training for {{ person.full_name }}
                </h3>
                <form
                    v-if="training.status === 2 && training.state === 1"
                    @submit.prevent="start"
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
                            Description
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ training.description }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Provider
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ training.provider }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Status
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <p
                                class="inline-flex rounded-full px-2 text-xs font-semibold leading-5"
                                :class="{
                                    'bg-blue-100 text-blue-800': status === 'pending',
                                    'bg-green-100 text-green-800': status === 'approved',
                                    'bg-red-100 text-red-800': status === 'rejected'
                                }"
                            >
                                {{ status }}
                            </p>
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            State
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <p
                                class="inline-flex rounded-full px-2 text-xs font-semibold leading-5"
                                :class="{
                                    'bg-orange-100 text-orange-800': state === 'not started',
                                    'bg-blue-100 text-blue-800': state === 'started',
                                    'bg-green-100 text-green-800': state === 'completed'
                                }"
                            >
                                {{ state }}
                            </p>
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Location
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ training.location ?? '-' }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Cost
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ Number.isInteger(training.cost) ? `${training.cost} ${training.cost_currency}` : '-' }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Duration
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ training.duration ?? '-' }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Notes
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ training.notes ?? '-' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
</template>
