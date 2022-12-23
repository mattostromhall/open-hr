<script setup lang="ts">
import Sidebar from '@/Components/Sidebar.vue'
import ShowSidebarButton from '@/Components/ShowSidebarButton.vue'
import FlashMessages from '@/Components/FlashMessages.vue'
import Notifications from '@/Components/Notifications.vue'
import SecondaryIndigoButton from '../Components/Controls/SecondaryIndigoButton.vue'
import {Inertia} from '@inertiajs/inertia'
import {usePage} from '@inertiajs/inertia-vue3'
import type {ComputedRef} from 'vue'
import {computed} from 'vue'

const impersonating: ComputedRef<boolean> = computed(() => usePage().props.value.impersonating)

function cancelImpersonation() {
    Inertia.delete('/users/impersonate')
}
</script>

<template>
    <section class="min-h-screen">
        <div
            v-if="impersonating"
            class="px-6 py-3 bg-blue-500 flex justify-end"
        >
            <SecondaryIndigoButton @click="cancelImpersonation">
                Cancel Impersonation
            </SecondaryIndigoButton>
        </div>
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