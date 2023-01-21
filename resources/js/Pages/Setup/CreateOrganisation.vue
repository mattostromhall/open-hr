<script setup lang="ts">
import {useForm} from '@inertiajs/vue3'
import {computed} from 'vue'
import type {ComputedRef} from 'vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import FileInput from '@/Components/Controls/FileInput.vue'
import ImagePreview from '@/Components/ImagePreview.vue'

const emit = defineEmits(['nextStep'])

type OrganisationSetup = {
    name: string,
    logo?: File
}

const form = useForm<OrganisationSetup>({
    name: '',
    logo: undefined
})

const preview: ComputedRef<string> = computed(() => {
    return form.logo
        ? URL.createObjectURL(form.logo)
        : ''
})

function submit(): void {
    form.post('/setup/organisation', {
        onSuccess: () => {
            emit('nextStep')
        }
    })
}
</script>

<template>
    <form
        class="space-y-6"
        @submit.prevent="submit"
    >
        <div>
            <FormLabel>Organisation Name</FormLabel>
            <div class="mt-1">
                <TextInput
                    v-model="form.name"
                    :error="form.errors.name"
                    input-id="organisation-name"
                    input-name="organisation-name"
                    @reset="form.clearErrors('name')"
                />
            </div>
        </div>
        <div class="flex flex-col justify-center mt-8">
            <FormLabel>Upload Logo</FormLabel>
            <FileInput
                :error="form.errors.logo"
                input-id="logo"
                input-name="logo"
                @reset="form.clearErrors('logo')"
                @update:model-value="form.logo = $event"
            />
            <ImagePreview
                class="mt-5"
                :image="preview"
                name="Organisation logo"
            />
        </div>
        <div>
            <button
                type="submit"
                class="flex justify-center py-2 px-4 w-full text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md border border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-sm"
                :disabled="form.processing"
            >
                Next
            </button>
        </div>
    </form>
</template>