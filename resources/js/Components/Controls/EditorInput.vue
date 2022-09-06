<script setup lang="ts">
import {useEditor, EditorContent} from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import {Placeholder} from '@tiptap/extension-placeholder'
import {Underline} from '@tiptap/extension-underline'
import EditorMenu from './EditorMenu.vue'
import {watch} from 'vue'

const props = defineProps<{
    modelValue: string
}>()

const emit = defineEmits(['update:modelValue'])

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
            class: 'w-full min-h-48 prose max-w-none focus:outline-none bg-white block pt-16 pb-3 px-3 placeholder:text-gray-400 rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 focus:ring-1 shadow-sm appearance-none'
        },
    },
    content: props.modelValue,
    onUpdate: () => {
        emit('update:modelValue', editor.value?.getHTML())
    },
})

watch(() => props.modelValue, (value) => {
    if (editor.value?.getHTML() === value) {
        return
    }

    editor.value?.commands.setContent(value, false)
})
</script>

<template>
    <div class="relative">
        <EditorMenu
            class="absolute top-0 left-0 z-10"
            :editor="editor"
        />
        <EditorContent :editor="editor" />
    </div>
</template>