<script setup lang="ts">
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import type {Task} from '../../../types'
import {Inertia} from '@inertiajs/inertia'
import {PencilIcon} from '@heroicons/vue/24/outline'
import {ref} from 'vue'
import type {Ref} from 'vue'
import Edit from './Edit.vue'

defineProps<{
    tasks: Task[]
}>()

const editing: Ref<Set<number>> = ref(new Set())

function isEditing(task: Task): boolean {
    return editing.value.has(task.id)
}

function edit(task: Task) {
    editing.value.add(task.id)
}

function removeFromEditing(task: Task) {
    editing.value.delete(task.id)
}

function overdue(task: Task): boolean {
    return task.days_remaining < 0
}

function complete(task: Task) {
    return Inertia.post(`/tasks/${task.id}/complete`)
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
        >
            <div
                v-if="! isEditing(task)"
                class="bg-white shadow sm:rounded-md"
            >
                <div class="flex items-center justify-between py-4 sm:py-5 sm:px-6">
                    <p
                        v-if="! task.completed_at"
                        class="inline-flex rounded-full px-2 text-xs font-semibold capitalize leading-5"
                        :class="{
                            'bg-blue-100 text-blue-800': ! overdue(task),
                            'bg-red-100 text-red-800': overdue(task)
                        }"
                    >
                        {{ ! overdue(task) ? `${task.days_remaining} days remaining` : 'overdue' }}
                    </p>
                    <p
                        v-else
                        class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold capitalize leading-5 text-green-800"
                    >
                        complete
                    </p>
                    <form
                        v-if="! task.completed_at"
                        @submit.prevent="complete(task)"
                    >
                        <IndigoButton>Mark as complete</IndigoButton>
                    </form>
                </div>
                <div class="border-t border-gray-200">
                    <div
                        class="prose p-4 pb-0 sm:px-6"
                        v-html="task.description"
                    />
                </div>
                <div class="flex justify-end p-4 text-indigo-600 sm:p-6">
                    <button
                        type="button"
                        @click="edit(task)"
                    >
                        <PencilIcon class="h-4 w-4" /><span class="sr-only" />
                    </button>
                </div>
            </div>
            <Edit
                v-else
                :task="task"
                @updated="removeFromEditing(task)"
            />
        </li>
    </ul>
</template>