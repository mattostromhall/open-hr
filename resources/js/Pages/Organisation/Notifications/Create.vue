<script setup lang="ts">
import {Head, useForm} from '@inertiajs/vue3'
import type {InertiaForm} from '@inertiajs/vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import type {Breadcrumb, Notification} from '../../../types'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import EditorInput from '@/Components/Controls/EditorInput.vue'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'

type NotificationData = Pick<Notification, 'title'|'body'|'link'>

const form: InertiaForm<NotificationData> = useForm({
    title: undefined,
    body: '',
    link: undefined
})

const breadcrumbs: Breadcrumb[] = [
    {
        link: '/organisation/notifications',
        display: 'Notifications'
    },
    {
        display: 'Create'
    }
]
</script>

<template>
    <Head>
        <title>Organisation Notifications</title>
    </Head>

    <PageHeading>
        Create Organisation Notification
        <template #link>
            <LightIndigoLink href="/organisation/notifications">
                View all
            </LightIndigoLink>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        dashboard="/dashboard/organisation"
        class="pt-8 px-8"
    />
    <section class="p-8">
        <div class="space-y-6 sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0">
            <form @submit.prevent="form.post('/organisation/notifications')">
                <div class="shadow sm:rounded-md">
                    <div class="space-y-6 bg-white py-6 px-4 sm:rounded-t-md sm:p-6">
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
                                <EditorInput
                                    v-model="form.body"
                                    :error="form.errors.body"
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
                    <div class="flex justify-end bg-gray-50 py-3 px-4 text-right sm:rounded-b-md sm:px-6">
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