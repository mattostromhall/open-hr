<script setup lang="ts">
import {useEditor, EditorContent} from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
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
        Underline
    ],
    editorProps: {
        attributes: {
            class: 'w-full min-h-48 prose prose-sm sm:prose lg:prose-lg focus:outline-none bg-white block pt-20 pb-6 px-6 placeholder:text-gray-400 rounded-md border border-gray-300 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 focus:ring-1 shadow-sm appearance-none'
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
        <EditorContent :editor="editor" />
        <EditorMenu
            class="absolute top-0 left-0"
            :editor="editor"
        />
    </div>
</template>