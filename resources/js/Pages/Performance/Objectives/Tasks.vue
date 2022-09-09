<script setup lang="ts">
import {StarIcon, PlusIcon} from '@heroicons/vue/outline'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import CreateTask from './CreateTask.vue'
import type {Objective, Task} from '../../../types'
import {ref} from 'vue'
import type {Ref} from 'vue'

const props = defineProps<{
    objective: Objective,
    tasks: Task[]
}>()

const showCreateForm: Ref<boolean> = ref(false)
</script>

<template>
    <CreateTask
        v-if="showCreateForm"
        :objective="objective"
    />
    <div
        v-else
        class="mt-6 bg-white py-6 px-4 text-center shadow sm:rounded-md sm:p-6"
    >
        <StarIcon class="mx-auto h-12 w-12 text-gray-400" />
        <h3
            v-if="tasks.length === 0"
            class="mt-2 text-sm font-medium text-gray-900"
        >
            No Tasks
        </h3>
        <div class="mt-6 flex justify-center">
            <IndigoButton @click="showCreateForm = true">
                <PlusIcon class="mr-2 -ml-1 h-5 w-5" />
                {{ tasks.length > 0 ? 'Add another Task' : 'Add Task' }}
            </IndigoButton>
        </div>
    </div>
</template>