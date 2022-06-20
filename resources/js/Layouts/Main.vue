<script setup lang="ts">
import Sidebar from '@/Components/Sidebar.vue'
import ShowSidebarButton from '@/Components/ShowSidebarButton.vue'
import FlashMessages from '@/Components/FlashMessages.vue'
import Notifications from '@/Components/Notifications.vue'

</script>

<template>
    <section class="min-h-screen">
        <FlashMessages />
        <div>
            <Sidebar />
            <div class="flex flex-col flex-1 md:pl-64">
                <ShowSidebarButton />
                <main class="flex-1 min-h-screen bg-gray-100">
                    <slot />
                </main>
                <Notifications />
            </div>
        </div>
    </section>
</template>