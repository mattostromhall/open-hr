<script setup lang="ts">
import FileInput from '@/Components/Controls/FileInput.vue'
import {ref} from 'vue'
import type {Ref} from 'vue'
import FilePreview from '../../../Components/FilePreview.vue'

const files: Ref<File | File[] | undefined> = ref()
</script>

<template>
    <div>
        <FileInput
            input-id="upload"
            input-name="upload"
            :multiple="true"
            @update:model-value="files = $event"
        />
        <FilePreview
            v-for="(file, index) in files"
            :key="index"
            class="mt-5"
            :file="file"
            :name="file?.name"
        />
    </div>
</template>