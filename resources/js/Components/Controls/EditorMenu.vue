<script setup lang="ts">
import type {Editor} from '@tiptap/vue-3'
import {ref} from 'vue'
import type {Ref} from 'vue'
import SimpleDropdown from '@/Components/SimpleDropdown.vue'

const props = defineProps<{
    editor?: Editor
}>()

const showHeadingOptions: Ref<boolean> = ref(false)
</script>

<template>
    <div class="flex flex-wrap items-center justify-center space-x-2 rounded-sm px-3 pt-3">
        <button
            type="button"
            class="rounded-sm bg-indigo-50 p-2"
            :class="{'bg-indigo-700': editor?.isActive('bold')}"
            @click="editor.chain().focus().toggleBold().run()"
        >
            <svg
                class="h-4 w-4 text-indigo-500"
                :class="{'text-indigo-100': editor?.isActive('bold')}"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 24 24"
            >
                <g>
                    <path
                        fill="none"
                        d="M0 0h24v24H0z"
                    />
                    <path d="M8 11h4.5a2.5 2.5 0 1 0 0-5H8v5zm10 4.5a4.5 4.5 0 0 1-4.5 4.5H6V4h6.5a4.5 4.5 0 0 1 3.256 7.606A4.498 4.498 0 0 1 18 15.5zM8 13v5h5.5a2.5 2.5 0 1 0 0-5H8z" />
                </g>
            </svg>
        </button>
        <button
            type="button"
            class="rounded-sm bg-indigo-50 p-2"
            :class="{'bg-indigo-700': editor?.isActive('underline')}"
            @click="editor.chain().focus().toggleUnderline().run()"
        >
            <svg
                class="h-4 w-4 text-indigo-500"
                :class="{'text-indigo-100': editor?.isActive('underline')}"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 24 24"
            >
                <g>
                    <path
                        fill="none"
                        d="M0 0h24v24H0z"
                    />
                    <path d="M8 3v9a4 4 0 1 0 8 0V3h2v9a6 6 0 1 1-12 0V3h2zM4 20h16v2H4v-2z" />
                </g>
            </svg>
        </button>
        <button
            type="button"
            class="rounded-sm bg-indigo-50 p-2"
            :class="{'bg-indigo-700': editor?.isActive('italic')}"
            @click="editor.chain().focus().toggleItalic().run()"
        >
            <svg
                class="h-4 w-4 text-indigo-500"
                :class="{'text-indigo-100': editor?.isActive('italic')}"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 24 24"
            >
                <g>
                    <path
                        fill="none"
                        d="M0 0h24v24H0z"
                    />
                    <path d="M15 20H7v-2h2.927l2.116-12H9V4h8v2h-2.927l-2.116 12H15z" />
                </g>
            </svg>
        </button>
        <button
            type="button"
            class="rounded-sm bg-indigo-50 p-2"
            @click="editor.chain().focus().setParagraph().run()"
        >
            <svg
                class="h-4 w-4 text-indigo-500"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 24 24"
            >
                <g>
                    <path
                        fill="none"
                        d="M0 0h24v24H0z"
                    />
                    <path d="M12 6v15h-2v-5a6 6 0 1 1 0-12h10v2h-3v15h-2V6h-3zm-2 0a4 4 0 1 0 0 8V6z" />
                </g>
            </svg>
        </button>
        <SimpleDropdown
            v-model="showHeadingOptions"
            position="below-right"
        >
            <template #button="{toggleDropdown}">
                <button
                    type="button"
                    class="rounded-sm bg-indigo-50 p-2"
                    :class="{'bg-indigo-700': editor?.isActive('heading')}"
                    aria-expanded="true"
                    aria-haspopup="true"
                    @click="toggleDropdown"
                >
                    <svg
                        class="h-4 w-4 text-indigo-500"
                        :class="{'text-indigo-100': editor?.isActive('heading')}"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <g>
                            <path
                                fill="none"
                                d="M0 0H24V24H0z"
                            />
                            <path d="M13 20h-2v-7H4v7H2V4h2v7h7V4h2v16zm8-12v12h-2v-9.796l-2 .536V8.67L19.5 8H21z" />
                        </g>
                    </svg>
                </button>
            </template>
            <template #default="{hideDropdown}">
                <ul
                    class="py-2"
                    @click="hideDropdown"
                >
                    <li
                        class="cursor-pointer px-6 py-1 text-2xl hover:bg-gray-50"
                        :class="{'bg-gray-100': editor?.isActive('heading', {level: 1})}"
                        @click="editor.chain().focus().toggleHeading({level: 1}).run()"
                    >
                        Heading 1
                    </li>
                    <li
                        class="cursor-pointer px-6 py-1.5 text-xl hover:bg-gray-50"
                        :class="{'bg-gray-100': editor?.isActive('heading', {level: 2})}"
                        @click="editor.chain().focus().toggleHeading({level: 2}).run()"
                    >
                        Heading 2
                    </li>
                    <li
                        class="cursor-pointer px-6 py-1.5 text-lg hover:bg-gray-50"
                        :class="{'bg-gray-100': editor?.isActive('heading', {level: 3})}"
                        @click="editor.chain().focus().toggleHeading({level: 3}).run()"
                    >
                        Heading 3
                    </li>
                    <li
                        class="cursor-pointer px-6 py-2 hover:bg-gray-50"
                        :class="{'bg-gray-100': editor?.isActive('heading', {level: 4})}"
                        @click="editor.chain().focus().toggleHeading({level: 4}).run()"
                    >
                        Heading 4
                    </li>
                    <li
                        class="cursor-pointer px-6 py-2.5 text-sm hover:bg-gray-50"
                        :class="{'bg-gray-100': editor?.isActive('heading', {level: 5})}"
                        @click="editor.chain().focus().toggleHeading({level: 5}).run()"
                    >
                        Heading 5
                    </li>
                    <li
                        class="cursor-pointer px-6 py-3 text-xs hover:bg-gray-50"
                        :class="{'bg-gray-100': editor?.isActive('heading', {level: 6})}"
                        @click="editor.chain().focus().toggleHeading({level: 6}).run()"
                    >
                        Heading 6
                    </li>
                </ul>
            </template>
        </SimpleDropdown>
        <button
            type="button"
            class="rounded-sm bg-indigo-50 p-2"
            :class="{'bg-indigo-700': editor?.isActive('bulletList')}"
            @click="editor.chain().focus().toggleBulletList().run()"
        >
            <svg
                class="h-4 w-4 text-indigo-500"
                :class="{'text-indigo-100': editor?.isActive('bulletList')}"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 24 24"
            >
                <g>
                    <path
                        fill="none"
                        d="M0 0h24v24H0z"
                    />
                    <path d="M8 4h13v2H8V4zM4.5 6.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 7a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6.9a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zM8 11h13v2H8v-2zm0 7h13v2H8v-2z" />
                </g>
            </svg>
        </button>
        <button
            type="button"
            class="rounded-sm bg-indigo-50 p-2"
            :class="{'bg-indigo-700': editor?.isActive('orderedList')}"
            @click="editor.chain().focus().toggleOrderedList().run()"
        >
            <svg
                class="h-4 w-4 text-indigo-500"
                :class="{'text-indigo-100': editor?.isActive('orderedList')}"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 24 24"
            >
                <g>
                    <path
                        fill="none"
                        d="M0 0h24v24H0z"
                    />
                    <path d="M8 4h13v2H8V4zM5 3v3h1v1H3V6h1V4H3V3h2zM3 14v-2.5h2V11H3v-1h3v2.5H4v.5h2v1H3zm2 5.5H3v-1h2V18H3v-1h3v4H3v-1h2v-.5zM8 11h13v2H8v-2zm0 7h13v2H8v-2z" />
                </g>
            </svg>
        </button>
        <button
            type="button"
            class="rounded-sm bg-indigo-50 p-2"
            :class="{'bg-indigo-700': editor?.isActive('codeBlock')}"
            @click="editor.chain().focus().toggleCodeBlock().run()"
        >
            <svg
                class="h-4 w-4 text-indigo-500"
                :class="{'text-indigo-100': editor?.isActive('codeBlock')}"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 24 24"
            >
                <g>
                    <path
                        fill="none"
                        d="M0 0h24v24H0z"
                    />
                    <path d="M16.95 8.464l1.414-1.414 4.95 4.95-4.95 4.95-1.414-1.414L20.485 12 16.95 8.464zm-9.9 0L3.515 12l3.535 3.536-1.414 1.414L.686 12l4.95-4.95L7.05 8.464z" />
                </g>
            </svg>
        </button>
        <button
            type="button"
            class="rounded-sm bg-indigo-50 p-2"
            :class="{'bg-indigo-700': editor?.isActive('blockquote')}"
            @click="editor.chain().focus().toggleBlockquote().run()"
        >
            <svg
                class="h-4 w-4 text-indigo-500"
                :class="{'text-indigo-100': editor?.isActive('blockquote')}"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 24 24"
            >
                <g>
                    <path
                        fill="none"
                        d="M0 0h24v24H0z"
                    />
                    <path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 0 1-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 0 1-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179z" />
                </g>
            </svg>
        </button>
    </div>
</template>