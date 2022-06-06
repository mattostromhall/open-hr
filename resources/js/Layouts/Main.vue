<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import Sidebar from '@/Components/Sidebar.vue'
import ShowSidebarButton from '@/Components/ShowSidebarButton.vue'
import FlashMessages from '../Components/FlashMessages.vue'

const showSidebar: Ref<boolean> = ref(false)

function show(): void {
    showSidebar.value = true
}

function hide(): void {
    showSidebar.value = false
}
</script>

<template>
    <section class="min-h-screen">
        <FlashMessages />
        <div>
            <Sidebar
                :show="showSidebar"
                @hide="hide"
            />
            <div class="flex flex-col flex-1 md:pl-64">
                <ShowSidebarButton @show="show" />
                <main class="flex-1 min-h-screen bg-gray-100">
                    <slot />
                </main>
            </div>
        </div>
    </section>
</template>