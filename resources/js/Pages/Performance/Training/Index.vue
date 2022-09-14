<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import {AcademicCapIcon} from '@heroicons/vue/24/outline'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import RequestTraining from './RequestTraining.vue'

type ActiveTab = 'request'

const activeTab: Ref<ActiveTab> = ref('request')

function setActive(tab: ActiveTab): void {
    activeTab.value = tab
}

function isActive(tab: string): boolean {
    return activeTab.value === tab
}
</script>

<template>
    <Head>
        <title>Training</title>
    </Head>

    <PageHeading>
        Training
    </PageHeading>
    <div class="p-8 lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:col-span-3 lg:p-0">
            <nav class="space-y-1">
                <button
                    class="group flex w-full items-center rounded-md py-2 px-3 text-sm font-medium"
                    :class="{
                        'text-gray-900 hover:text-gray-900 hover:bg-gray-50': ! isActive('request'),
                        'bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white': isActive('request')
                    }"
                    aria-current="page"
                    @click="setActive('request')"
                >
                    <AcademicCapIcon
                        class="mr-3 -ml-1 h-6 w-6 shrink-0"
                        :class="{
                            'text-gray-400 group-hover:text-gray-500': ! isActive('request'),
                            'text-indigo-500 group-hover:text-indigo-500': isActive('request')
                        }"
                    />
                    <span class="truncate">Request Training</span>
                </button>
            </nav>
        </aside>
        <RequestTraining
            v-if="isActive('request')"
            @set-active="setActive"
        />
    </div>
</template>