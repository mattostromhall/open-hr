<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import {useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import EmailInput from '@/Components/Controls/EmailInput.vue'
import PhoneInput from '@/Components/Controls/PhoneInput.vue'
import ToggleInput from '@/Components/Controls/ToggleInput.vue'

const props = defineProps({
    user: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['nextStep'])

interface HRSetup {
    user_id: number,
    contact_number: string,
    contact_email: string,
}

const form: InertiaForm<HRSetup> = useForm({
    user_id: props.user.id,
    contact_number: '',
    contact_email: ''
})

const sameEmail: Ref<boolean> = ref(true)

function submit(): void {
    if (sameEmail.value) {
        form.contact_email = props.user.email
    }

    form.post('/setup/hr', {
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
            <div>
                <FormLabel>Contact number</FormLabel>
                <div class="mt-1">
                    <PhoneInput
                        v-model="form.contact_number"
                        :error="form.errors.contact_number"
                        input-id="contact_number"
                        input-name="contact_number"
                        @reset="form.clearErrors('contact_number')"
                    />
                </div>
            </div>
            <div class="mt-4">
                <FormLabel>Contact email same as user email?</FormLabel>
                <div class="mt-1">
                    <ToggleInput v-model="sameEmail" />
                </div>
                <div
                    v-if="!sameEmail"
                    class="mt-2"
                >
                    <FormLabel>Contact email</FormLabel>
                    <div class="mt-1">
                        <EmailInput
                            v-model="form.contact_email"
                            :error="form.errors.contact_email"
                            input-id="contact_email"
                            input-name="contact_email"
                            @reset="form.clearErrors('contact_email')"
                        />
                    </div>
                </div>
            </div>
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