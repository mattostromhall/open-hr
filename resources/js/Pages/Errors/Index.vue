<script setup lang="ts">
import type {StatusCode} from '../../types'
import type {ComputedRef} from 'vue'
import {computed} from 'vue'
import IndigoLink from '@/Components/Controls/IndigoLink.vue'
import SecondaryIndigoButton from '@/Components/Controls/SecondaryIndigoButton.vue'
import {useClipboard} from '@vueuse/core'
import {Head} from '@inertiajs/inertia-vue3'

const props = defineProps<{
    status: StatusCode,
    hash?: string
}>()

type StatusCodeMap = {[code in StatusCode]: string}

const title: ComputedRef<string> = computed(() => {
    const statuses: StatusCodeMap = {
        503: 'Service Unavailable',
        500: 'Server Error',
        404: 'Page Not Found',
        403: 'Forbidden'
    }

    return statuses[props.status]
})

const description: ComputedRef<string> = computed(() => {
    const statuses: StatusCodeMap = {
        503: 'Sorry, we are doing some maintenance. Please check back soon.',
        500: 'Whoops, something went wrong on our servers.',
        404: 'Sorry, the page you are looking for could not be found.',
        403: 'Sorry, you do not have permission to visit this page.'
    }

    return statuses[props.status]
})

const {copy, copied} = useClipboard()

function copyHash() {
    if (props.hash) {
        copy(props.hash)
    }
}
</script>

<script lang="ts">
export default {
    layout: null
}
</script>

<template>
    <Head>
        <title>Error | {{ status }}</title>
    </Head>
    <div class="min-h-full bg-white py-16 px-6 sm:py-24 md:grid md:place-items-center lg:px-8">
        <div class="mx-auto max-w-max">
            <main class="sm:flex">
                <p class="text-4xl font-bold tracking-tight text-indigo-600 sm:text-5xl">
                    {{ status }}
                </p>
                <div class="sm:ml-6">
                    <div class="sm:border-l sm:border-gray-200 sm:pl-6">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                            {{ title }}
                        </h1>
                        <p class="mt-1 text-base text-gray-500">
                            {{ description }}
                        </p>
                        <p
                            v-if="hash"
                            class="mt-1 text-base text-gray-500"
                        >
                            Please provide the following hash to your systems administrator
                        </p>
                        <button
                            class="font-bold text-indigo-600"
                            @click="copyHash"
                        >
                            <span v-if="! copied">{{ hash }}</span>
                            <span v-else>Copied!</span>
                        </button>
                    </div>
                    <div class="mt-10 flex space-x-3 sm:border-l sm:border-transparent sm:pl-6">
                        <IndigoLink href="/dashboard">
                            Back to Dashboard
                        </IndigoLink>
                        <SecondaryIndigoButton
                            v-if="hash"
                            @click="copyHash"
                        >
                            <span v-if="! copied">Copy Hash</span>
                            <span v-else>Copied!</span>
                        </SecondaryIndigoButton>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>