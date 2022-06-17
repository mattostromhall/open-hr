<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import Sidebar from '@/Components/Sidebar.vue'
import ShowSidebarButton from '@/Components/ShowSidebarButton.vue'
import FlashMessages from '@/Components/FlashMessages.vue'
import Notifications from '@/Components/Notifications.vue'

const sidebar: Ref<boolean> = ref(false)
const notifications: Ref<boolean> = ref(false)

function showSidebar(): void {
    sidebar.value = true
}

function hideSidebar(): void {
    sidebar.value = false
}

function showNotifications(): void {
    notifications.value = true
}

function hideNotifications(): void {
    notifications.value = false
}
</script>

<template>
    <section class="min-h-screen">
        <FlashMessages />
        <div>
            <Sidebar
                :show="sidebar"
                @hide="hideSidebar"
                @show-notifications="showNotifications"
            />
            <div class="flex flex-col flex-1 md:pl-64">
                <ShowSidebarButton @show="showSidebar" />
                <main class="flex-1 min-h-screen bg-gray-100">
                    <slot />
                </main>
                <Notifications
                    :show="notifications"
                    @hide="hideNotifications"
                />
            </div>
        </div>
    </section>
</template>