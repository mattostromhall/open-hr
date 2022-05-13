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
import type {Currency, RecurrenceInterval} from '../../types'

const props = defineProps({
    user: {
        type: Object,
        required: true
    }
})

interface PersonData {
    user_id: number,
    first_name: string,
    last_name: string,
    pronouns: string,
    dob: string,
    position: string,
    remuneration: number,
    remuneration_interval: RecurrenceInterval,
    remuneration_currency: Currency,
    holiday_allocation: number,
    sickness_allocation: number,
    contact_number: string,
    contact_email: string,
    started_on: string,
    manager_id?: number,
    department_id?: number,
    title?: string,
    initials?: string,
    finished_on?: string
}

const form: InertiaForm<PersonData> = useForm({
    user_id: props.user.id,
    first_name: '',
    last_name: '',
    pronouns: '',
    dob: '',
    position: '',
    remuneration: 0,
    remuneration_interval: 'yearly',
    remuneration_currency: 'GBP',
    holiday_allocation: 25,
    sickness_allocation: 10,
    contact_number: '',
    contact_email: '',
    started_on: '',
    title: '',
    initials: '',
    manager_id: undefined,
    department_id: undefined,
    finished_on: undefined
})

const sameEmail: Ref<boolean> = ref(true)

function submit(): void {
    if (sameEmail.value) {
        form.contact_email = props.user.email
    }

    form.post('/setup/person')
}

function skipStage(): void {
    Inertia.post('/setup')
}
</script>

<template>
    <form
        class="space-y-6"
        @submit.prevent="submit"
    >
        <div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email address</label>
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
                <label class="block text-sm font-medium text-gray-700">Password</label>
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
                <label class="block text-sm font-medium text-gray-700">Password confirmation</label>
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
                <label class="block text-sm font-medium text-gray-700">Contact number</label>
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