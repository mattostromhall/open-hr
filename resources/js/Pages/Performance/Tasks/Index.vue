<script setup lang="ts">
import {StarIcon, PlusIcon} from '@heroicons/vue/outline'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import {Link} from '@inertiajs/inertia-vue3'
import type {Objective, Task} from '../../../types'

const props = defineProps<{
    objective: Objective,
    tasks: Task[]
}>()
</script>

<template>
    <div
        v-if="tasks.length === 0"
        class="mt-6 bg-white py-6 px-4 text-center shadow sm:rounded-md sm:p-6"
    >
        <StarIcon class="mx-auto h-12 w-12 text-gray-400" />
        <h3 class="mt-2 text-sm font-medium text-gray-900">
            No Tasks
        </h3>
        <div class="mt-6 flex justify-center">
            <Link :href="`/objectives/${objective.id}/tasks/create`">
                <IndigoButton>
                    <PlusIcon class="mr-2 -ml-1 h-5 w-5" />
                    Add Task
                </IndigoButton>
            </Link>
        </div>
    </div>
</template>