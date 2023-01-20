<script setup lang="ts">
import {Head, useForm} from '@inertiajs/vue3'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import PasswordInput from '@/Components/Controls/PasswordInput.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'

interface ConfirmPasswordForm {
    password: string
}

const form: ConfirmPasswordForm = useForm({
    password: '',
})

const submit = () => {
    form.post('/confirm-password', {
        onFinish: () => form.reset(),
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
        <title>Confirm Password</title>
    </Head>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <h1 class="text-4xl font-bold text-center text-indigo-400">
            Open HR
        </h1>
        <h2 class="my-6 text-3xl font-bold text-center text-indigo-100">
            Login
        </h2>
        <div class="py-8 px-4 bg-white shadow sm:px-10 sm:rounded-lg">
            <div class="mb-4 text-sm text-gray-600">
                This is a secure area of the application. Please confirm your password before continuing.
            </div>
            <form @submit.prevent="submit">
                <div>
                    <FormLabel>Password</FormLabel>
                    <div class="mt-1">
                        <PasswordInput
                            v-model="form.password"
                            :error="form.errors.password"
                            input-id="password"
                            input-name="password"
                            autofocus
                            @reset="form.clearErrors('password')"
                        />
                    </div>
                </div>
                <div class="mt-4">
                    <IndigoButton
                        :disabled="form.processing"
                        class="w-full"
                    >
                        Confirm
                    </IndigoButton>
                </div>
            </form>
        </div>
    </div>
</template>
