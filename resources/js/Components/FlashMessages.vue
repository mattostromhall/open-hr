<script setup lang="ts">
import {ExclamationCircleIcon, InformationCircleIcon} from '@heroicons/vue/outline'
import StickyBanner from '@/Components/StickyBanner.vue'
import type {FlashMessage} from '../types'
import useFlashMessage from '../Hooks/useFlashMessage'
import type {ComputedRef} from 'vue'

const flash: ComputedRef<FlashMessage> = useFlashMessage()

function resetSuccessData() {
    flash.value.success = undefined
}

function resetErrorData() {
    flash.value.error = undefined
}
</script>

<template>
    <StickyBanner
        v-if="flash.success"
        :auto-close="true"
        @closed="resetSuccessData"
    >
        <span class="inline-flex items-center font-semibold">
            <InformationCircleIcon class="mr-2 w-5 h-5" />
            {{ flash.success }}
        </span>
    </StickyBanner>
    <StickyBanner
        v-if="flash.error"
        banner-type="error"
        :auto-close="true"
        @closed="resetErrorData"
    >
        <span class="inline-flex items-center font-semibold">
            <ExclamationCircleIcon class="mr-2 w-5 h-5" />
            {{ flash.error }}
        </span>
    </StickyBanner>
</template>
