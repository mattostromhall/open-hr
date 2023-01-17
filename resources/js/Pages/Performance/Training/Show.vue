<script setup lang="ts">
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import type {Breadcrumb, Person, Training} from '../../../types'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import {Head, useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import RedButton from '@/Components/Controls/RedButton.vue'
import {Inertia} from '@inertiajs/inertia'
import SimpleModal from '@/Components/SimpleModal.vue'
import type {Ref} from 'vue'
import {ref} from 'vue'
import {ExclamationTriangleIcon} from '@heroicons/vue/24/outline'
import GreyOutlineButton from '@/Components/Controls/GreyOutlineButton.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import usePermissions from '../../../Hooks/usePermissions'

const props = defineProps<{
    training: Training,
    status: string,
    state: string,
    person: Pick<Person, 'first_name' | 'last_name' | 'full_name'>
}>()

const {can} = usePermissions()

const breadcrumbs: Breadcrumb[] = [
    {
        link: '/training',
        display: 'Training'
    },
    {
        display: props.training.description
    }
]

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

const showDeleteModal: Ref<boolean> = ref(false)

function deleteTraining() {
    return Inertia.delete(`/training/${props.training.id}`)
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
                <LightIndigoLink
                    v-if="can('update-training')"
                    :href="`/training/${training.id}/edit`"
                >
                    Edit
                </LightIndigoLink>
                <LightIndigoLink
                    v-if="can('create-training')"
                    href="/training"
                >
                    Request Training
                </LightIndigoLink>
            </div>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        class="pt-8 px-8"
    />
    <section class="w-full p-8 sm:max-w-6xl">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="flex items-center justify-between py-5 px-4 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Training for {{ person.full_name }}
                </h3>
                <div class="flex space-x-2">
                    <RedButton
                        v-if="can('delete-training')"
                        type="button"
                        @click="showDeleteModal = true"
                    >
                        Cancel
                    </RedButton>
                    <SimpleModal
                        v-model="showDeleteModal"
                        modal-classes="px-4 pt-5 pb-4 text-left sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                    >
                        <form @submit.prevent="deleteTraining">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <ExclamationTriangleIcon class="h-6 w-6 text-red-600" />
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3
                                        id="modal-title"
                                        class="text-lg font-medium leading-6 text-gray-900"
                                    >
                                        Confirm Delete
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            Are you sure you want to cancel the Training Request? This action cannot be undone.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                <RedButton class="w-full sm:w-auto sm:ml-3">
                                    Confirm
                                </RedButton>
                                <GreyOutlineButton
                                    class="w-full sm:w-auto mt-3 sm:mt-0"
                                    @click="showDeleteModal = false"
                                >
                                    Cancel
                                </GreyOutlineButton>
                            </div>
                        </form>
                    </SimpleModal>
                    <form
                        v-if="training.status === 2 && training.state === 1 && can('update-training')"
                        @submit.prevent="start"
                    >
                        <IndigoButton>Start</IndigoButton>
                    </form>
                    <form
                        v-if="training.status === 2 && training.state === 2 && can('complete-training')"
                        @submit.prevent="complete"
                    >
                        <IndigoButton>Mark as complete</IndigoButton>
                    </form>
                </div>
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
