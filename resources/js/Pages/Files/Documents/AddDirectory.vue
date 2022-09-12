<script setup lang="ts">
import {FolderAddIcon} from '@heroicons/vue/24/outline'
import TextInput from '../../../Components/Controls/TextInput.vue'
import {useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import {computed, nextTick, ref} from 'vue'
import type {Ref, ComputedRef} from 'vue'
import IndigoButton from '../../../Components/Controls/IndigoButton.vue'

const props = defineProps<{
    path: string
}>()

interface DirectoryData {
    path: string
}

const nameInput: Ref<{input: HTMLInputElement} | null> = ref(null)

const name: Ref<string> = ref('/')

const path: ComputedRef<string> = computed(() =>
    name.value.startsWith('/') ? `${props.path}${name.value}` : `${props.path}/${name.value}`
)

const form: InertiaForm<DirectoryData> = useForm({
    path: ''
})

const showName: Ref<boolean> = ref(false)

function showNameInput() {
    if (showName.value) {
        return
    }

    showName.value = true
    nextTick(() => nameInput.value?.input.focus())
}

function hideNameInput() {
    showName.value = false
}

function submit() {
    if (name.value === '' || name.value === '/') {
        return
    }

    form.path = path.value

    form.post('/directories', {
        onSuccess: () => hideNameInput()
    })
}
</script>

<template>
    <tr
        class="cursor-pointer bg-blue-50"
        @click="showNameInput"
    >
        <td class="w-5 whitespace-nowrap py-2 pl-3 pr-1 text-sm font-medium text-blue-500">
            <FolderAddIcon
                class="h-5 w-5"
                @click="submit"
            />
        </td>
        <td class="whitespace-nowrap p-2 text-sm text-blue-500">
            <TextInput
                v-if="showName"
                ref="nameInput"
                v-model="name"
                class="text-xs text-gray-900"
                :error="form.errors.path"
                input-id="name"
                input-name="name"
                @reset="form.clearErrors('path')"
                @keydown.enter="submit"
                @keydown.esc="hideNameInput"
            />
            <span v-else>Add folder</span>
        </td>
        <td class="whitespace-nowrap p-2">
            <div
                v-if="showName"
                class="flex space-x-2 text-xs"
            >
                <IndigoButton
                    class="py-1 px-2 text-xs"
                    @click="submit"
                >
                    Add
                </IndigoButton>
                <button @click.stop="hideNameInput">
                    Cancel
                </button>
            </div>
        </td>
        <td />
        <td />
        <td />
    </tr>
</template>