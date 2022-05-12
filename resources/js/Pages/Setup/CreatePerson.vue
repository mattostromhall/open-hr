<script setup lang="ts">
import PasswordInput from '@/Components/Forms/PasswordInput.vue'
import EmailInput from '@/Components/Forms/EmailInput.vue'
import TextInput from '@/Components/Forms/TextInput.vue'
import PhoneInput from '@/Components/Forms/PhoneInput.vue'
import {useForm} from '@inertiajs/inertia-vue3'
import {Inertia} from '@inertiajs/inertia'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import ToggleInput from '@/Components/Controls/ToggleInput.vue'
import {ref} from 'vue'
import type {Ref} from 'vue'

const props = defineProps({
    userId: {
        type: Number,
        required: true
    }
})

interface PersonSetup {
    user_id: number,
    email: string,
    contact_number: string,
    contact_email?: string,
}

const personForm: InertiaForm<PersonSetup> = useForm({
    user_id: props.userId,
    email: '',
    password: '',
    password_confirmation: '',
    contact_number: '',
    contact_email: ''
})

const sameEmail: Ref<boolean> = ref(true)

function submitHRForm(): void {
    if (sameEmail.value) {
        personForm.contact_email = personForm.email
    }

    personForm.post('/setup/person')
}

function skipStage(): void {
    Inertia.post('hr/setup')
}
</script>

<template>
    <form
        class="space-y-6"
        @submit.prevent="submitHRForm"
    >
        <div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email address</label>
                <div class="mt-1">
                    <EmailInput
                        v-model="personForm.email"
                        :error="personForm.errors.email"
                        input-id="email"
                        input-name="email"
                        @reset="personForm.clearErrors('email')"
                    />
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <div class="mt-1">
                    <PasswordInput
                        v-model="personForm.password"
                        :error="personForm.errors.password"
                        input-id="password"
                        input-name="password"
                        @reset="personForm.clearErrors('password')"
                    />
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Password confirmation</label>
                <div class="mt-1">
                    <PasswordInput
                        v-model="personForm.password_confirmation"
                        :error="personForm.errors.password"
                        input-id="password_confirmation"
                        input-name="password_confirmation"
                        @reset="personForm.clearErrors('password')"
                    />
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Contact number</label>
                <div class="mt-1">
                    <PhoneInput
                        v-model="personForm.contact_number"
                        :error="personForm.errors.contact_number"
                        input-id="contact_number"
                        input-name="contact_number"
                        @reset="personForm.clearErrors('contact_number')"
                    />
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Contact email same as email address?</label>
                <div class="mt-1">
                    <ToggleInput v-model="sameEmail" />
                </div>
                <div
                    v-if="!sameEmail"
                    class="mt-2"
                >
                    <label class="block text-sm font-medium text-gray-700">Contact email</label>
                    <div class="mt-1">
                        <TextInput
                            v-model="personForm.contact_email"
                            :error="personForm.errors.contact_email"
                            input-id="contact_email"
                            input-name="contact_email"
                            @reset="personForm.clearErrors('contact_email')"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div>
            <button
                type="submit"
                class="flex justify-center py-2 px-4 w-full text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md border border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-sm"
            >
                Next
            </button>
        </div>
    </form>
    <div class="mt-3 text-center">
        <button
            type="button"
            class="text-sm font-semibold text-indigo-600"
            @click="skipStage"
        >
            Skip
        </button>
    </div>
</template>