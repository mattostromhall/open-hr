<script setup lang="ts">
import FileInput from '@/Components/Controls/FileInput.vue'
import {computed, ref} from 'vue'
import type {Ref, ComputedRef} from 'vue'
import ImagePreview from '../../../Components/ImagePreview.vue'
import FilePreview from '../../../Components/FilePreview.vue'

const file: Ref<File | undefined> = ref()
const preview: ComputedRef<string> = computed(() => {
    return file.value
        ? URL.createObjectURL(file.value)
        : ''
})
</script>

<template>
    <div>
        <FileInput
            input-id="upload"
            input-name="upload"
            @update:model-value="file = $event"
        />
        <FilePreview
            class="mt-5"
            :file="file"
            :name="file?.name"
        />
        <ImagePreview
            class="mt-5"
            :image="preview"
            :name="file?.name"
        />
    </div>
</template>