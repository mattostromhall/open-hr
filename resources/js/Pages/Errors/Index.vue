<script lang="ts">
import type {StatusCode} from '../../types'
import type {ComputedRef} from 'vue'
import {computed} from 'vue'

defineProps<{
    status: StatusCode,
    hash: string
}>()

const title: ComputedRef<string> = computed(() => {
    const statuses: {[K in StatusCode]: string} = {
        503: 'Service Unavailable',
        500: 'Server Error',
        404: 'Page Not Found',
        403: 'Forbidden',
    }[this.status]
})
export default {
    props: {
        status: Number,
    },
    computed: {
        title() {
            return {
                503: 'Service Unavailable',
                500: 'Server Error',
                404: 'Page Not Found',
                403: 'Forbidden',
            }[this.status]
        },
        description() {
            return {
                503: 'Sorry, we are doing some maintenance. Please check back soon.',
                500: 'Whoops, something went wrong on our servers.',
                404: 'Sorry, the page you are looking for could not be found.',
                403: 'Sorry, you are forbidden from accessing this page.',
            }[this.status]
        },
    },
}
</script>

<template>
    <div class="flex min-h-full flex-col bg-white pt-16 pb-12">
        <main class="mx-auto flex w-full max-w-7xl grow flex-col justify-center px-6 lg:px-8">
            <div class="flex shrink-0 justify-center">
                <a
                    href="/"
                    class="inline-flex"
                >
                    <span class="sr-only">Your Company</span>
                    <img
                        class="h-12 w-auto"
                        src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                        alt=""
                    >
                </a>
            </div>
            <div class="py-16">
                <div class="text-center">
                    <p class="text-base font-semibold text-indigo-600">
                        {{ status }}
                    </p>
                    <h1 class="mt-2 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                        Page not found.
                    </h1>
                    <p class="mt-2 text-base text-gray-500">
                        Sorry, we couldn’t find the page you’re looking for.
                    </p>
                    <div class="mt-6">
                        <a
                            href="#"
                            class="text-base font-medium text-indigo-600 hover:text-indigo-500"
                        >
                            Go back home
                            <span aria-hidden="true"> &rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>