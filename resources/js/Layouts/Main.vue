<script setup lang="ts">
import Sidebar from '@/Components/Sidebar.vue'
import ShowSidebarButton from '@/Components/ShowSidebarButton.vue'
import FlashMessages from '@/Components/FlashMessages.vue'
import Notifications from '@/Components/Notifications.vue'
import SecondaryIndigoButton from '../Components/Controls/SecondaryIndigoButton.vue'
import {router} from '@inertiajs/vue3'
import useImpersonation from '../Hooks/useImpersonation'

const impersonating = useImpersonation()

function cancelImpersonation() {
    router.delete('/users/impersonate')
}
</script>

<template>
    <section class="min-h-screen">
        <FlashMessages />
        <div>
            <Sidebar />
            <div class="flex flex-col flex-1 md:pl-64">
                <ShowSidebarButton />
                <div
                    v-if="impersonating"
                    class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 flex justify-end"
                >
                    <SecondaryIndigoButton @click="cancelImpersonation">
                        Cancel Impersonation
                    </SecondaryIndigoButton>
                </div>
                <main class="flex-1 min-h-screen bg-gray-100">
                    <slot />
                </main>
                <Notifications />
            </div>
        </div>
    </section>
</template>