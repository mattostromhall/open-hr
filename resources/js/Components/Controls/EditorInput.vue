<script setup lang="ts">
import {useEditor, EditorContent} from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import {Placeholder} from '@tiptap/extension-placeholder'
import {Underline} from '@tiptap/extension-underline'
import EditorMenu from './EditorMenu.vue'
import {computed, watch} from 'vue'
import type {ComputedRef} from 'vue'
import EditorPreview from './EditorPreview.vue'

const props = defineProps<{
    modelValue: string,
    error?: string
}>()

const emit = defineEmits(['update:modelValue', 'reset'])

const editorClasses: ComputedRef<string> = computed(() => props.error
    ? 'w-full min-h-48 prose max-w-none focus:outline-none bg-white block pt-16 pb-3 px-3 placeholder:text-gray-400 rounded-md border border-red-500 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 focus:ring-1 shadow-sm appearance-none'
    : 'w-full min-h-48 prose max-w-none focus:outline-none bg-white block pt-16 pb-3 px-3 placeholder:text-gray-400 rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 focus:ring-1 shadow-sm appearance-none'
)

const editor = useEditor({
    extensions: [
        StarterKit,
        Underline,
        Placeholder.configure({
            placeholder: 'Write something…',
            emptyEditorClass: 'first:before:text-gray-400 first:before:float-left first:before:content-[attr(data-placeholder)] first:before:pointer-events-none first:before:h-0'
        })
    ],
    editorProps: {
        attributes: {
            class: editorClasses.value
        },
    },
    content: props.modelValue,
    onUpdate: () => {
        if (props.error) {
            emit('reset')
        }

        emit('update:modelValue', editor.value?.getHTML())
    },
})

watch(() => props.modelValue, (value) => {
    if (editor.value?.getHTML() === value) {
        return
    }

    editor.value?.commands.setContent(value, false)
})

watch(() => props.error, () => {
    editor.value?.setOptions({
        editorProps: {
            attributes: {
                class: editorClasses.value
            },
        },
    })
})
</script>

<template>
    <div class="relative">
        <EditorMenu
            class="absolute top-0 left-0 z-10"
            :editor="editor"
        />
        <EditorPreview class="absolute top-0 right-0 z-10" />
        <EditorContent :editor="editor" />
        <p
            v-if="error"
            class="mt-1 text-sm text-red-500"
        >
            {{ error }}
        </p>
    </div>
</template>