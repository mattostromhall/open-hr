<script setup lang="ts">
import {onBeforeMount, computed, ref} from 'vue'

const props = defineProps({
    position: {
        type: String,
        default: 'top'
    },
    bannerType: {
        type: String,
        default: 'success'
    },
    autoClose: {
        type: Boolean,
        default: false
    },
    displayFor: {
        type: Number,
        default: 5000
    }
})
const emit = defineEmits(['closed'])

const show = ref(true)

const bannerPosition = computed(() => {
    return {
        'top-0 pt-2': props.position === 'top',
        'bottom-0 pb-2': props.position === 'bottom'
    }
})

const bannerColour = computed(() => {
    return {
        'bg-indigo-600': props.bannerType === 'success',
        'bg-red-700': props.bannerType === 'error'
    }
})

const closeButtonColour = computed(() => {
    return {
        'hover:bg-rss-green-700': props.bannerType === 'success',
        'hover:bg-red-800': props.bannerType === 'error'
    }
})

onBeforeMount(() => {
    if (props.autoClose) {
        setTimeout(() => {
            close()
        }, props.displayFor)
    }
})

function close() {
    show.value = false
}

function afterLeave() {
    emit('closed')
}
</script>

<template>
    <transition
        name="fade"
        mode="out-in"
        @after-leave="afterLeave"
    >
        <div
            v-if="show"
            class="fixed inset-x-0 z-50"
            :class="bannerPosition"
        >
            <div class="px-2 mx-auto max-w-screen-lg sm:px-6 lg:px-6">
                <div
                    class="p-2 rounded-lg shadow-lg sm:p-3"
                    :class="bannerColour"
                >
                    <div class="flex flex-wrap justify-between items-center">
                        <div class="flex flex-1 items-center w-0">
                            <p class="ml-3 font-medium text-white truncate">
                                <slot />
                            </p>
                        </div>
                        <div class="shrink-0 order-2 sm:order-3 sm:ml-2">
                            <button
                                type="button"
                                class="flex p-2 -mr-1 rounded-md focus:outline-none focus:ring-2 focus:ring-white"
                                :class="closeButtonColour"
                                @click="close"
                            >
                                <span class="sr-only">Dismiss</span>
                                <svg
                                    class="w-6 h-6 text-white"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.25s ease-in-out;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
