<script setup lang="ts">
import {Head, Link, useForm} from '@inertiajs/vue3'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import EmailInput from '@/Components/Controls/EmailInput.vue'
import PasswordInput from '@/Components/Controls/PasswordInput.vue'
import ToggleInput from '@/Components/Controls/ToggleInput.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'

defineProps<{
    canResetPassword: boolean,
    status?: string,
    deactivated?: string
}>()

interface LoginForm {
    email: string,
    password: string,
    remember: boolean
}

const form: LoginForm = useForm({
    email: '',
    password: '',
    remember: false
})

const submit = () => {
    form.post('/login', {
        onFinish: () => form.reset('password'),
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
        <title>Log in</title>
    </Head>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <h1 class="text-4xl font-bold text-center text-indigo-400">
            Open HR
        </h1>
        <h2 class="my-6 text-3xl font-bold text-center text-indigo-100">
            Login
        </h2>
        <div class="py-8 px-4 bg-white shadow sm:px-10 sm:rounded-lg">
            <div
                v-if="status"
                class="mb-4 text-sm font-medium text-green-600"
            >
                {{ status }}
            </div>
            <div
                v-if="deactivated"
                class="mb-4 text-sm font-medium text-red-600"
            >
                {{ deactivated }}
            </div>
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

                <div class="flex items-center mt-4 space-x-2">
                    <ToggleInput v-model="form.remember" />
                    <FormLabel>Remember me</FormLabel>
                </div>

                <div class="mt-4">
                    <IndigoButton
                        :disabled="form.processing"
                        class="w-full"
                    >
                        Log in
                    </IndigoButton>
                    <Link
                        v-if="canResetPassword"
                        href="/forgot-password"
                        class="block mt-3 text-sm text-gray-600 hover:text-gray-900 underline"
                    >
                        Forgot your password?
                    </Link>
                </div>
            </form>
        </div>
    </div>
</template>
