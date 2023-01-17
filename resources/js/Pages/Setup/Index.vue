<script setup lang="ts">
import {computed, reactive} from 'vue'
import {Head} from '@inertiajs/inertia-vue3'
import type {ComputedRef} from 'vue'
import CreateOrganisation from '@/Pages/Setup/CreateOrganisation.vue'
import ProgressStages from '@/Components/ProgressStages.vue'
import CreatePerson from '@/Pages/Setup/CreatePerson.vue'

interface SetupStages {
    stages: number[],
    current: number
}

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    stage: {
        type: Number,
        default: 1
    }
})

const setup: SetupStages = reactive({
    stages: [1, 2],
    current: props.stage
})

const setupText: ComputedRef<string> = computed(() => {
    if (setup.current === 2) {
        return 'Add your personal information'
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
    <Head>
        <title>Setup</title>
    </Head>

    <section class="mt-8 w-full">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h1 class="text-4xl font-bold text-center text-indigo-400">
                Open HR
            </h1>
            <h2 class="my-6 text-3xl font-bold text-center text-indigo-100">
                {{ setupText }}
            </h2>
        </div>
        <div
            class="py-8 px-4 bg-white shadow sm:px-10 sm:mx-auto sm:w-full sm:rounded-lg mb-8"
            :class="{
                'sm:max-w-md': setup.current === 1,
                'sm:max-w-3xl': setup.current === 2
            }"
        >
            <CreateOrganisation
                v-if="setup.current === 1"
                @next-step="setup.current = 2"
            />
            <CreatePerson
                v-if="setup.current === 2"
                :user="user"
            />
            <ProgressStages
                :stages="setup.stages"
                :current="setup.current"
            />
        </div>
    </section>
</template>