<script setup lang="ts">
defineProps<{
    stages: number[],
    current: number
}>()
</script>

<template>
    <nav
        class="flex justify-center items-center mt-6"
        aria-label="Progress"
    >
        <ol
            role="list"
            class="flex items-center space-x-5"
        >
            <li
                v-for="stage in stages"
                :key="stage"
            >
                <span
                    :class="{'relative flex items-center justify-center': stage === current}"
                    aria-current="step"
                >
                    <span
                        v-if="stage === current"
                        class="flex absolute p-px w-5 h-5"
                        aria-hidden="true"
                    >
                        <span class="w-full h-full bg-indigo-200 rounded-full" />
                    </span>
                    <span
                        :class="{
                            'bg-indigo-600': stage <= current,
                            'hover:bg-indigo-900': stage > current,
                            'bg-gray-200 hover:bg-gray-400': stage > current,
                        }"
                        class="block relative w-2.5 h-2.5 rounded-full"
                        aria-hidden="true"
                    />
                    <span class="sr-only">Stage {{ stage }}</span>
                </span>
            </li>
        </ol>
    </nav>
</template>