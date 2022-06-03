<script setup lang="ts">
defineProps({
    objectives: {
        type: Array,
        default: () => []
    }
})
</script>

<template>
    <section aria-labelledby="objectives-title">
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="p-6">
                <h2
                    id="objectives-title"
                    class="text-base font-medium text-gray-900"
                >
                    Objectives
                </h2>
                <div class="flow-root mt-6">
                    <h3
                        v-if="objectives.length === 0"
                        class="text-sm font-medium text-gray-900"
                    >
                        No objectives
                    </h3>
                    <ul
                        v-else
                        role="list"
                        class="-my-5 divide-y divide-gray-200"
                    >
                        <li
                            v-for="{id, title, description} in objectives"
                            :key="id"
                            class="py-4"
                        >
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ title }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        {{ description }}
                                    </p>
                                </div>
                                <div>
                                    <a
                                        href="#"
                                        class="inline-flex items-center py-0.5 px-2.5 text-sm font-medium leading-5 text-gray-700 bg-white hover:bg-gray-50 rounded-full border border-gray-300 shadow-sm"
                                    > View </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="mt-6">
                    <a
                        href="#"
                        class="flex justify-center items-center py-2 px-4 w-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 rounded-md border border-gray-300 shadow-sm"
                    > View all </a>
                </div>
            </div>
        </div>
    </section>
</template>