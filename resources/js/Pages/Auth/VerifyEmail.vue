<script setup lang="ts">
import {computed} from 'vue'
import {Head, Link, useForm} from '@inertiajs/inertia-vue3'
import type {ComputedRef} from 'vue'

const props = defineProps({
    status: {
        type: String,
        default: ''
    }
})

const form = useForm({})

const submit = () => {
    form.post('/email/verification-notification')
}

const verificationLinkSent: ComputedRef<boolean> = computed(() => props.status === 'verification-link-sent')
</script>

<script lang="ts">
import Basic from '@/Layouts/Basic.vue'

export default {
    layout: Basic
}
</script>

<template>
    <Head title="Email Verification" />

    <div class="mb-4 text-sm text-gray-600">
        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
    </div>
    <div
        v-if="verificationLinkSent"
        class="mb-4 text-sm font-medium text-green-600"
    >
        A new verification link has been sent to the email address you provided during registration.
    </div>
    <form @submit.prevent="submit">
        <div class="flex justify-between items-center mt-4">
            <button
                type="submit"
                class="flex justify-center py-2 px-4 w-full text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md border border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shadow-sm"
                :disabled="form.processing"
            >
                Resend Verification Email
            </button>
            <Link
                href="/logout"
                method="post"
                as="button"
                class="text-sm text-gray-600 hover:text-gray-900 underline"
            >
                Log Out
            </Link>
        </div>
    </form>
</template>
