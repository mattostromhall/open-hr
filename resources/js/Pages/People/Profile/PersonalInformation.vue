<script setup lang="ts">
import EmailInput from '@/Components/Controls/EmailInput.vue'
import TextInput from '@/Components/Controls/TextInput.vue'
import PhoneInput from '@/Components/Controls/PhoneInput.vue'
import {useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import DateInput from '@/Components/Controls/DateInput.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'

const props = defineProps({
    person: {
        type: Object,
        required: true
    }
})

interface PersonalInformationData {
    first_name: string,
    last_name: string,
    dob: string,
    contact_number: string,
    contact_email: string,
    title?: string,
    initials?: string,
    pronouns?: string
}

const form: InertiaForm<PersonalInformationData> = useForm({
    first_name: props.person.first_name,
    last_name: props.person.last_name,
    dob: props.person.dob,
    contact_number: props.person.contact_number,
    contact_email: props.person.contact_email,
    title: props.person.title,
    initials: props.person.initials,
    pronouns: props.person.pronouns
})

function submit(): void {
    form.patch(`/people/${props.person.id}/profile`)
}
</script>

<template>
    <div class="space-y-6 sm:px-6 sm:w-full sm:max-w-3xl lg:col-span-9 lg:px-0">
        <form @submit.prevent="submit">
            <div class="shadow sm:overflow-hidden sm:rounded-md">
                <div class="py-6 px-4 space-y-6 bg-white sm:p-6">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Personal Information
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Manage the personal information stored for you.
                        </p>
                    </div>

                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>First name <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <TextInput
                                    v-model="form.first_name"
                                    :error="form.errors.first_name"
                                    input-id="first_name"
                                    input-name="first_name"
                                    @reset="form.clearErrors('first_name')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Last name <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <TextInput
                                    v-model="form.last_name"
                                    :error="form.errors.last_name"
                                    input-id="last_name"
                                    input-name="last_name"
                                    @reset="form.clearErrors('last_name')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-6 lg:col-span-2">
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
                        <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                            <FormLabel>Initials</FormLabel>
                            <div class="mt-1">
                                <TextInput
                                    v-model="form.initials"
                                    :error="form.errors.initials"
                                    input-id="initials"
                                    input-name="initials"
                                    @reset="form.clearErrors('initials')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                            <FormLabel>Pronouns</FormLabel>
                            <div class="mt-1">
                                <TextInput
                                    v-model="form.pronouns"
                                    :error="form.errors.pronouns"
                                    input-id="pronouns"
                                    input-name="pronouns"
                                    @reset="form.clearErrors('pronouns')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <FormLabel>Date of birth <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <DateInput
                                    v-model="form.dob"
                                    :error="form.errors.dob"
                                    input-id="dob"
                                    input-name="dob"
                                    @reset="form.clearErrors('dob')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Contact number <RequiredIcon /></FormLabel>
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
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Contact email <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <EmailInput
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
                <div class="flex justify-end py-3 px-4 text-right bg-gray-50 sm:px-6">
                    <IndigoButton
                        :disabled="form.processing"
                    >
                        Save
                    </IndigoButton>
                </div>
            </div>
        </form>
    </div>
</template>