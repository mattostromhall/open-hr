<script setup lang="ts">
import {ChevronRightIcon, PlusIcon, BookmarkSlashIcon} from '@heroicons/vue/24/outline'
import {Link} from '@inertiajs/inertia-vue3'
import type {Training} from '../../../types'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import usePermissions from '../../../Hooks/usePermissions'

defineProps<{
    notStarted: Training[]
}>()

const {can} = usePermissions()

const emit = defineEmits(['setActive'])

function requestTraining() {
    emit('setActive', 'request')
}
</script>
<template>
    <div class="sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0">
        <div
            v-if="notStarted.length === 0"
            class="bg-white py-6 px-4 text-center shadow sm:rounded-md sm:p-6"
        >
            <BookmarkSlashIcon class="mx-auto h-12 w-12 text-gray-400" />
            <h3 class="mt-2 text-sm font-medium text-gray-900">
                No un-started Training!
            </h3>
            <div
                v-if="can('create-training')"
                class="mt-6 flex justify-center"
            >
                <IndigoButton @click="requestTraining">
                    <PlusIcon class="mr-2 -ml-1 h-5 w-5" />
                    Request
                </IndigoButton>
            </div>
        </div>
        <div
            v-else
            class="bg-white shadow sm:rounded-md"
        >
            <ul
                role="list"
                class="divide-y divide-gray-200"
            >
                <li
                    v-for="(training, index) in notStarted"
                    :key="index"
                >
                    <Link
                        :href="`/training/${training.id}`"
                        class="block hover:bg-gray-50"
                    >
                        <div class="flex items-center p-4 sm:px-6">
                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                <div class="w-44 truncate">
                                    <h3>{{ training.provider }}</h3>
                                </div>
                                <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                    <p class="truncate px-3 text-sm text-gray-400">
                                        {{ training.description }}
                                    </p>
                                </div>
                                <div class="mt-4 shrink-0 sm:mt-0 sm:ml-5">
                                    <p class="inline-flex rounded-full bg-orange-100 px-2 text-xs font-semibold leading-5 text-orange-800">
                                        Not Started
                                    </p>
                                </div>
                            </div>
                            <div class="ml-5 shrink-0">
                                <ChevronRightIcon class="h-5 w-5 text-gray-400" />
                            </div>
                        </div>
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>