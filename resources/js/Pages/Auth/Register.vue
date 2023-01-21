<script setup lang="ts">
import {Head, Link, useForm} from '@inertiajs/vue3'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import EmailInput from '@/Components/Controls/EmailInput.vue'
import PasswordInput from '@/Components/Controls/PasswordInput.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import type {ConfirmablePassword, User} from '../../types'

type RegisterForm = Pick<User, 'email'> & ConfirmablePassword

const form = useForm<RegisterForm>({
    email: '',
    password: '',
    password_confirmation: ''
})

const submit = () => {
    form.post('/register', {
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
        <title>Register</title>
    </Head>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <h1 class="text-4xl font-bold text-center text-indigo-400">
            Open HR
        </h1>
        <h2 class="my-6 text-3xl font-bold text-center text-indigo-100">
            Register
        </h2>
        <div class="py-8 px-4 bg-white shadow sm:px-10 sm:rounded-lg">
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
                            :error="form.errors.password"
                            input-id="password_confirmation"
                            input-name="password_confirmation"
                            @reset="form.clearErrors('password')"
                        />
                    </div>
                </div>
                <div class="mt-4">
                    <IndigoButton
                        :disabled="form.processing"
                        class="w-full"
                    >
                        Create Account
                    </IndigoButton>
                    <Link
                        href="/login"
                        class="block mt-3 text-sm text-gray-600 hover:text-gray-900 underline"
                    >
                        Already registered?
                    </Link>
                </div>
            </form>
        </div>
    </div>
</template>
