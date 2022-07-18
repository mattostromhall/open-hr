<script setup lang="ts">
import {Head, useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import type {Notification} from '../../../types'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import TextAreaInput from '@/Components/Controls/TextAreaInput.vue'
import RequiredIcon from '@/Components/RequiredIcon.vue'

type NotificationData = Pick<Notification, 'title'|'body'|'link'>

const form: InertiaForm<NotificationData> = useForm({
    title: undefined,
    body: '',
    link: undefined
})
</script>

<template>
    <Head title="Organisation Notifications" />

    <PageHeading>
        Create Notification
        <template #link>
            <LightIndigoLink href="/organisation/announcements">
                View all
            </LightIndigoLink>
        </template>
    </PageHeading>

    <section class="p-8">
        <div class="space-y-6 sm:px-6 sm:w-full sm:max-w-3xl lg:col-span-9 lg:px-0">
            <form @submit.prevent="form.post('/organisation/notifications')">
                <div class="shadow sm:rounded-md">
                    <div class="py-6 px-4 space-y-6 bg-white sm:p-6 sm:rounded-t-md">
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Notification Information
                            </h3>
                        </div>
                        <div class="mt-4">
                            <FormLabel>Title</FormLabel>
                            <div class="mt-1">
                                <TextInput
                                    v-model="form.title"
                                    :error="form.errors.title"
                                    input-id="title"
                                    input-name="title"
                                    @reset="form.clearErrors('title')"
                                />
                            </div>
                        </div>
                        <div class="mt-4">
                            <FormLabel>Body <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <TextAreaInput
                                    v-model="form.body"
                                    :error="form.errors.body"
                                    input-id="body"
                                    input-name="body"
                                    @reset="form.clearErrors('body')"
                                />
                            </div>
                        </div>
                        <div class="mt-4">
                            <FormLabel>Link</FormLabel>
                            <div class="mt-1">
                                <TextInput
                                    v-model="form.link"
                                    :error="form.errors.link"
                                    input-id="link"
                                    input-name="link"
                                    @reset="form.clearErrors('link')"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end py-3 px-4 text-right bg-gray-50 sm:px-6 sm:rounded-b-md">
                        <IndigoButton
                            :disabled="form.processing"
                        >
                            Create
                        </IndigoButton>
                    </div>
                </div>
            </form>
        </div>
    </section>
</template>