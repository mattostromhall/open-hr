<script setup lang="ts">
import {Head, useForm} from '@inertiajs/vue3'
import type {InertiaForm} from '@inertiajs/vue3'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import EmailInput from '@/Components/Controls/EmailInput.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'

defineProps<{
    status?: string
}>()

interface ForgotPasswordForm {
    email: string
}

const form: InertiaForm<ForgotPasswordForm> = useForm({
    email: '',
})

const submit = () => {
    form.post('/forgot-password')
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
        <title>Forgot Password</title>
    </Head>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <h1 class="text-4xl font-bold text-center text-indigo-400">
            Open HR
        </h1>
        <h2 class="my-6 text-3xl font-bold text-center text-indigo-100">
            Forgot password
        </h2>
        <div class="py-8 px-4 bg-white shadow sm:px-10 sm:rounded-lg">
            <div class="mb-4 text-sm text-gray-600">
                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            </div>

            <div
                v-if="status"
                class="mb-4 text-sm font-medium text-green-600"
            >
                {{ status }}
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
                    <IndigoButton
                        :disabled="form.processing"
                        class="w-full"
                    >
                        Email Password Reset Link
                    </IndigoButton>
                </div>
            </form>
        </div>
    </div>
</template>
