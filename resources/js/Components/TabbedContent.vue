<script setup lang="ts">
import {ref} from 'vue'
import type {Component} from 'vue'
import type {Ref} from 'vue'
import type {TabbedContentItem} from '../types'
import * as Icons from '@heroicons/vue/24/outline'

const props = defineProps<{
    tabs: TabbedContentItem[]
    active: string
}>()

const active: Ref<TabbedContentItem['identifier']> = ref(props.active)

function setActive(identifier: TabbedContentItem['identifier']): void {
    const searchParams = new URLSearchParams(window.location.search)

    searchParams.set('active', identifier)
    history.replaceState(null, '', `${window.location.pathname}?${searchParams.toString()}`)

    active.value = identifier
}

function isActive(identifier: TabbedContentItem['identifier']): boolean {
    return active.value === identifier
}

function icon(tab: TabbedContentItem): Component {
    return Icons[tab.icon as keyof typeof Icons]
}
</script>

<template>
    <div class="p-8 lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:col-span-3 lg:p-0">
            <nav class="space-y-1">
                <button
                    v-for="tab in tabs"
                    :key="tab.identifier"
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive(tab.identifier),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive(tab.identifier)
                    }"
                    aria-current="page"
                    @click="setActive(tab.identifier)"
                >
                    <Component
                        :is="icon(tab)"
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive(tab.identifier),
                            'text-indigo-500 group-hover:text-indigo-500': isActive(tab.identifier)
                        }"
                    />
                    <span class="truncate">{{ tab.display }}</span>
                </button>
            </nav>
        </aside>
        <slot
            :active="active"
            :set-active="setActive"
            :is-active="isActive"
        />
    </div>
</template>