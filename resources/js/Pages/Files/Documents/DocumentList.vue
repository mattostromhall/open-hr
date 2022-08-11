<script setup lang="ts">
import type {DocumentListItem} from '../../../types'
import ListItem from './DocumentListItem.vue'
import AddDirectory from './AddDirectory.vue'

const props = defineProps<{
    path: string,
    items: DocumentListItem[]
}>()
</script>

<template>
    <div class="flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    scope="col"
                                    class="w-5 whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900"
                                >
                                    <span class="sr-only">Icon</span>
                                </th>
                                <th
                                    scope="col"
                                    class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    Name
                                </th>
                                <th
                                    scope="col"
                                    class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    Last Modified
                                </th>
                                <th
                                    scope="col"
                                    class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    Size
                                </th>
                                <th
                                    scope="col"
                                    class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900"
                                >
                                    Kind
                                </th>
                                <th
                                    scope="col"
                                    class="relative whitespace-nowrap py-3.5 pl-3 pr-4 sm:pr-6"
                                >
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <ListItem
                                v-for="item in items"
                                :key="item.name"
                                :item="item"
                            />
                            <AddDirectory :path="props.path" />
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>