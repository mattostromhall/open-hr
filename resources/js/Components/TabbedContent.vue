<script setup lang="ts">
import {ref} from 'vue'
import type {Component} from 'vue'
import type {Ref} from 'vue'
import type {SubMenuItem} from '../types'
import * as Icons from '@heroicons/vue/24/outline'

const props = defineProps<{
    subMenuItems: SubMenuItem[]
    active: string
}>()

const active: Ref<SubMenuItem['identifier']> = ref(props.active)

function setActive(identifier: SubMenuItem['identifier']): void {
    active.value = identifier
}

function isActive(identifier: SubMenuItem['identifier']): boolean {
    return active.value === identifier
}

function icon(subMenuItem: SubMenuItem): Component {
    return Icons[subMenuItem.icon as keyof typeof Icons]
}
</script>

<template>
    <div class="p-8 lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:col-span-3 lg:p-0">
            <nav class="space-y-1">
                <button
                    v-for="subMenuItem in subMenuItems"
                    :key="subMenuItem.identifier"
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive(subMenuItem.identifier),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive(subMenuItem.identifier)
                    }"
                    aria-current="page"
                    @click="setActive(subMenuItem.identifier)"
                >
                    <Component
                        :is="icon(subMenuItem)"
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive(subMenuItem.identifier),
                            'text-indigo-500 group-hover:text-indigo-500': isActive(subMenuItem.identifier)
                        }"
                    />
                    <span class="truncate">{{ subMenuItem.display }}</span>
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