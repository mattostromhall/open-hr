<script setup lang="ts">
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import {useDateFormat} from '@vueuse/core'
import type {Breadcrumb, Objective, Task} from '../../../types'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import {Inertia} from '@inertiajs/inertia'
import {Head} from '@inertiajs/inertia-vue3'
import Tasks from '@/Pages/Performance/Objectives/Tasks.vue'
import SimpleModal from '@/Components/SimpleModal.vue'
import type {Ref} from 'vue'
import {ref} from 'vue'
import {ExclamationTriangleIcon} from '@heroicons/vue/24/outline'
import RedButton from '@/Components/Controls/RedButton.vue'
import GreyOutlineButton from '@/Components/Controls/GreyOutlineButton.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'

const props = defineProps<{
    objective: Objective,
    tasks: Task[]
}>()

const breadcrumbs: Breadcrumb[] = [
    {
        link: '/performance?active=current',
        display: 'Performance'
    },
    {
        display: props.objective.title
    }
]

function status(objective: Objective): string {
    if (objective.completed_at) {
        return 'completed'
    }

    if (objective.days_remaining < 0) {
        return 'overdue'
    }

    return 'current'
}

function complete() {
    return Inertia.post(`/objectives/${props.objective.id}/complete`)
}

const showDeleteModal: Ref<boolean> = ref(false)

function deleteObjective() {
    return Inertia.delete(`/objectives/${props.objective.id}`)
}
</script>

<template>
    <Head>
        <title>View Holiday</title>
    </Head>

    <PageHeading>
        <span class="font-medium">Viewing</span> - {{ objective.title }}
        <template #link>
            <div class="flex space-x-2">
                <LightIndigoLink :href="`/objectives/${objective.id}/edit`">
                    Edit
                </LightIndigoLink>
                <LightIndigoLink href="/performance?active=current">
                    View all
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
                    Objective Information
                </h3>
                <div class="flex space-x-2">
                    <form
                        v-if="! objective.completed_at"
                        @submit.prevent="deleteObjective"
                    >
                        <RedButton
                            type="button"
                            @click="showDeleteModal = true"
                        >
                            Unset
                        </RedButton>
                        <SimpleModal
                            v-model="showDeleteModal"
                            modal-classes="px-4 pt-5 pb-4 text-left sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                        >
                            <form @submit.prevent="deleteObjective">
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
                                                Are you sure you want to unset the Objective? This action cannot be undone.
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
                    </form>
                    <form
                        v-if="! objective.completed_at"
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
