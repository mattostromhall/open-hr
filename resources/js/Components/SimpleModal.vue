<script setup lang="ts">
import {onBeforeUnmount, onMounted, ref, watch} from 'vue'
import type {Ref} from 'vue'
import {TransitionRoot} from '@headlessui/vue'

const props = defineProps<{
    modelValue: boolean,
    modalClasses?: string
}>()

const emit = defineEmits(['close', 'update:modelValue'])

watch(() => props.modelValue, () => {
    if (props.modelValue) {
        return document.querySelector('body')?.classList.add('overflow-hidden')
    }

    document.querySelector('body')?.classList.remove('overflow-hidden')
})

const modal: Ref<HTMLDivElement | null> = ref(null)

function handleResize() {
    if (! modal.value) {
        return
    }

    const bounding = modal.value.getBoundingClientRect()

    if (bounding.bottom >= window.innerHeight) {
        modal.value.classList.add('overflow-scroll')
    } else {
        modal.value.classList.remove('overflow-scroll')
    }
}

function close() {
    emit('close')
    emit('update:modelValue', false)
}

function handleEnter() {
    modal.value?.focus()
}

onMounted(() => {
    window.addEventListener('resize', handleResize)
    handleResize()
})

onBeforeUnmount(() => {
    document.querySelector('body')?.classList.remove('overflow-hidden')
    window.removeEventListener('resize', handleResize)
})
</script>

<template>
    <Teleport to="body">
        <TransitionRoot
            :show="modelValue"
            as="template"
            enter="transition ease-in-out duration-300"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="transition ease-in-out duration-300"
            leave-from="opacity-100"
            leave-to="opacity-0"
            @after-enter="handleEnter"
        >
            <section
                class="fixed top-0 left-0 z-50 flex h-screen w-screen flex-col items-center bg-gray-700 bg-opacity-50 p-16"
                @click.self="close"
            >
                <div
                    ref="modal"
                    class="rounded-md bg-white focus:outline-none"
                    :class="modalClasses"
                    tabindex="0"
                    @keyup.esc="close"
                >
                    <slot :close="close" />
                </div>
            </section>
        </TransitionRoot>
    </Teleport>
</template>