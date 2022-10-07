<script setup lang="ts">
import {XMarkIcon} from '@heroicons/vue/24/outline'
import IndigoButton from './IndigoButton.vue'
import SimpleModal from '../SimpleModal.vue'
import type {Ref} from 'vue'
import {ref} from 'vue'

defineProps<{
    previewContent: string
}>()

const show: Ref<boolean> = ref(false)
</script>

<template>
    <IndigoButton
        type="button"
        class="mx-3 mt-3 py-1 px-3"
        @click="show = true"
    >
        Preview
        <SimpleModal
            v-model="show"
            modal-classes="h-full w-full p-6 overflow-scroll"
        >
            <div class="flex justify-between">
                <div />
                <h2 class="text-xl font-semibold">
                    Preview
                </h2>
                <button
                    type="button"
                    class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:ring-2 focus:ring-indigo-500"
                >
                    <span class="sr-only">Close panel</span>
                    <XMarkIcon
                        class="h-6 w-6"
                        @click="show = false"
                    />
                </button>
            </div>
            <div
                class="prose mx-auto mt-6"
                v-html="previewContent"
            />
        </SimpleModal>
    </IndigoButton>
</template>