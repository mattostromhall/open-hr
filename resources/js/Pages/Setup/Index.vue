<script setup lang="ts">
import {computed, reactive} from 'vue'
import {Head} from '@inertiajs/inertia-vue3'
import type {ComputedRef} from 'vue'
import CreateOrganisation from '@/Pages/Setup/CreateOrganisation.vue'
import ProgressStages from '@/Components/ProgressStages.vue'
import CreateHR from '@/Pages/Setup/CreateHR.vue'
import CreatePerson from '@/Pages/Setup/CreatePerson.vue'

interface SetupStages {
    stages: number[],
    current: number
}

const props = defineProps({
    auth: {
        type: Object,
        required: true
    },
    stage: {
        type: Number,
        default: 1
    }
})

const setupStages: SetupStages = reactive({
    stages: [1, 2, 3],
    current: props.stage
})

const setupText: ComputedRef<string> = computed(() => {
    if (setupStages.current === 3) {
        return 'Add your personal information'
    }

    if (setupStages.current === 2) {
        return 'Add an HR contact information'
    }

    return 'Setup your Organisation'
})
</script>

<script lang="ts">
import Basic from '@/Layouts/Basic.vue'

export default {
    layout: Basic
}
</script>

<template>
    <Head title="Setup" />

    <section class="mt-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h1 class="text-4xl font-bold text-center text-indigo-400">
                Open HR
            </h1>
            <h2 class="my-6 text-3xl font-bold text-center text-indigo-100">
                {{ setupText }}
            </h2>
        </div>
        <div class="py-8 px-4 bg-white shadow sm:px-10 sm:rounded-lg">
            <CreateOrganisation
                v-if="setupStages.current === 1"
                @next-step="setupStages.current = 2"
            />
            <CreateHR
                v-if="setupStages.current === 2"
                :user="props.auth.user"
                @next-step="setupStages.current = 3"
            />
            <CreatePerson
                v-if="setupStages.current === 3"
                :user="props.auth.user"
            />
            <ProgressStages
                :stages="setupStages.stages"
                :current="setupStages.current"
            />
        </div>
    </section>
</template>