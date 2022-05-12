<script setup lang="ts">
import {ref} from 'vue'
import type {Ref} from 'vue'
import {useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import FormLabel from '@/Components/Forms/FormLabel.vue'
import PasswordInput from '@/Components/Forms/PasswordInput.vue'
import EmailInput from '@/Components/Forms/EmailInput.vue'
import PhoneInput from '@/Components/Forms/PhoneInput.vue'
import ToggleInput from '@/Components/Controls/ToggleInput.vue'

const emit = defineEmits(['nextStep'])

interface HRSetup {
    email: string,
    password: string,
    password_confirmation: string,
    contact_number: string,
    contact_email?: string,
}

const form: InertiaForm<HRSetup> = useForm({
    email: '',
    password: '',
    password_confirmation: '',
    contact_number: '',
    contact_email: ''
})

const sameEmail: Ref<boolean> = ref(true)

function submit(): void {
    if (sameEmail.value) {
        form.contact_email = form.email
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
                <FormLabel>Email</FormLabel>
                <div class="mt-1">
                    <EmailInput
                        v-model="form.email"
                        :error="form.errors.email"
                        input-id="email"
                        input-name="email"
                        @reset="form.clearErrors('email')"
                    />
                </div>
            </div>
            <div class="mt-4">
                <FormLabel>Password</FormLabel>
                <div class="mt-1">
                    <PasswordInput
                        v-model="form.password"
                        :error="form.errors.password"
                        input-id="password"
                        input-name="password"
                        @reset="form.clearErrors('password')"
                    />
                </div>
            </div>
            <div class="mt-4">
                <FormLabel>Password confirmation</FormLabel>
                <div class="mt-1">
                    <PasswordInput
                        v-model="form.password_confirmation"
                        :error="form.errors.password"
                        input-id="password_confirmation"
                        input-name="password_confirmation"
                        @reset="form.clearErrors('password')"
                    />
                </div>
            </div>
            <div class="mt-4">
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
                <FormLabel>Contact email same as email address?</FormLabel>
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