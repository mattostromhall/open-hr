<script setup lang="ts">
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import type {Task} from '../../../types'

defineProps<{
    tasks: Task[]
}>()

function overdue(task: Task): boolean {
    return task.days_remaining < 0
}

function complete() {
    //
}
</script>

<template>
    <ul
        role="list"
        class="space-y-3"
    >
        <li
            v-for="(task, index) in tasks"
            :key="index"
            class="bg-white shadow sm:rounded-md"
        >
            <div class="flex items-center justify-between py-4 sm:py-5 sm:px-6">
                <p
                    class="inline-flex rounded-full px-2 text-xs font-semibold capitalize leading-5"
                    :class="{
                        'bg-blue-100 text-blue-800': ! overdue(task),
                        'bg-red-100 text-red-800': overdue(task)
                    }"
                >
                    {{ ! overdue(task) ? `${task.days_remaining} days remaining` : 'overdue' }}
                </p>
                <form
                    v-if="! task.completed_at"
                    @submit.prevent="complete"
                >
                    <IndigoButton>Mark as complete</IndigoButton>
                </form>
            </div>
            <div class="border-t border-gray-200">
                <div
                    class="prose p-4 sm:px-6"
                    v-html="task.description"
                />
            </div>
        </li>
    </ul>
</template>