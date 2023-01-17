<script setup lang="ts">
import {Head, useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import EmailInput from '@/Components/Controls/EmailInput.vue'
import PasswordInput from '@/Components/Controls/PasswordInput.vue'

const props = defineProps({
    email: {
        type: String,
        default: ''
    },
    token: {
        type: String,
        default: ''
    }
})

interface ResetPasswordForm {
    token: string,
    email: string,
    password: string,
    password_confirmation: string
}

const form: InertiaForm<ResetPasswordForm> = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.post('/reset-password', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<script lang="ts">
import Basic from '@/Layouts/Basic.vue'

export default {
    layout: Basic
}
</script>

<template>
    <Head>
        <title>Reset Password</title>
    </Head>

    <form @submit.prevent="submit">
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
            <FormLabel>Confirm password</FormLabel>
            <div class="mt-1">
                <PasswordInput
                    v-model="form.password_confirmation"
                    :error="form.errors.password_confirmation"
                    input-id="password_confirmation"
                    input-name="password_confirmation"
                    @reset="form.clearErrors('password')"
                />
            </div>
        </div>
        <div class="mt-4">
            <button
                type="submit"
                class="flex justify-center py-2 px-4 w-full text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md border border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-sm"
                :disabled="form.processing"
            >
                Reset password
            </button>
        </div>
    </form>
</template>
