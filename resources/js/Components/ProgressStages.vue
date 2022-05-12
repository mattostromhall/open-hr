<script setup lang="ts">
const props = defineProps<{
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
                v-for="stage in props.stages"
                :key="stage"
            >
                <span
                    :class="{'relative flex items-center justify-center': stage === props.current}"
                    aria-current="step"
                >
                    <span
                        v-if="stage === props.current"
                        class="flex absolute p-px w-5 h-5"
                        aria-hidden="true"
                    >
                        <span class="w-full h-full bg-indigo-200 rounded-full" />
                    </span>
                    <span
                        :class="{
                            'bg-indigo-600': stage <= props.current,
                            'hover:bg-indigo-900': stage > props.current,
                            'bg-gray-200 hover:bg-gray-400': stage > props.current,
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