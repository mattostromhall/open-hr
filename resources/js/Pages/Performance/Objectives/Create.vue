<script setup lang="ts">
import EditorInput from '@/Components/Controls/EditorInput.vue'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import {useForm} from '@inertiajs/inertia-vue3'
import type {Objective} from '../../../types'

type ObjectiveData = Omit<Objective, 'id' | 'person_id' | 'completed_at' & {person_id?: number}>

const form: InertiaForm<ObjectiveData> = useForm({
    person_id: undefined,
    title: '',
    description: '',
    due_at: ''
})
</script>

<template>
    <div class="col-span-9">
        <EditorInput v-model="form.description" />
    </div>
</template>