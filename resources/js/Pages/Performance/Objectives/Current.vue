<script setup lang="ts">
import EditorInput from '@/Components/Controls/EditorInput.vue'
import {ref} from 'vue'

const content = ref('')
</script>

<template>
    <div class="col-span-9">
        <EditorInput v-model="content" />
    </div>
</template>