<script setup lang="ts">
import {PlusIcon} from '@heroicons/vue/24/solid'
import {MailIcon} from '@heroicons/vue/24/outline'
import TextInput from '@/Components/Controls/TextInput.vue'
import {useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import CountryInput from '@/Components/Controls/CountryInput.vue'
import {ref} from 'vue'
import type {Ref} from 'vue'

const props = defineProps({
    person: {
        type: Object,
        required: true
    },
    address: {
        type: Object,
        default: () => {
            return {
                address_line: '',
                country: '',
                town_city: '',
                region: '',
                postal_code: ''
            }
        }
    }
})

interface AddressData {
    id?: number
    address_line: string,
    country: string,
    town_city: string,
    region: string,
    postal_code: string
}

const showForm: Ref<boolean> = ref(!!props.address?.id)

const form: InertiaForm<AddressData> = useForm({
    id: props.address?.id,
    address_line: props.address?.address_line ?? '',
    country: props.address?.country ?? '',
    town_city: props.address?.town_city ?? '',
    region: props.address?.region ?? '',
    postal_code: props.address?.postal_code ?? ''
})

function show(): void {
    showForm.value = true
}

function submit(): void {
    props.address?.id
        ? form.put(`/addresses/${props.address.id}`)
        : form.post(`/people/${props.person.id}/address`)
}
</script>

<template>
    <div class="space-y-6 sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9 lg:px-0">
        <div class="shadow sm:rounded-md">
            <div
                v-if="! showForm"
                class="bg-white py-6 px-4 text-center sm:rounded-md sm:p-6"
            >
                <MailIcon class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    No address
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Add an address to this account
                </p>
                <div class="mt-6 flex justify-center">
                    <IndigoButton @click="show">
                        <PlusIcon class="mr-2 -ml-1 h-5 w-5" />
                        Add Address
                    </IndigoButton>
                </div>
            </div>
            <form
                v-if="showForm"
                @submit.prevent="submit"
            >
                <div class="space-y-6 bg-white py-6 px-4 sm:p-6">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Address
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Manage the address stored for you.
                        </p>
                    </div>

                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-5">
                            <FormLabel>Address <RequiredIcon /></FormLabel>
                            <TextInput
                                v-model="form.address_line"
                                :error="form.errors.address_line"
                                input-id="address_line"
                                input-name="address_line"
                                @reset="form.clearErrors('address_line')"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <FormLabel>Country <RequiredIcon /></FormLabel>
                            <CountryInput
                                v-model="form.country"
                                :error="form.errors.country"
                                input-id="country"
                                input-name="country"
                                @reset="form.clearErrors('country')"
                            />
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                            <FormLabel>Town/City <RequiredIcon /></FormLabel>
                            <TextInput
                                v-model="form.town_city"
                                :error="form.errors.town_city"
                                input-id="town_city"
                                input-name="town_city"
                                @reset="form.clearErrors('town_city')"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                            <FormLabel>Region <RequiredIcon /></FormLabel>
                            <TextInput
                                v-model="form.region"
                                :error="form.errors.region"
                                input-id="region"
                                input-name="region"
                                @reset="form.clearErrors('region')"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                            <FormLabel>Postal code <RequiredIcon /></FormLabel>
                            <TextInput
                                v-model="form.postal_code"
                                :error="form.errors.postal_code"
                                input-id="postal_code"
                                input-name="postal_code"
                                @reset="form.clearErrors('postal_code')"
                            />
                        </div>
                    </div>
                </div>
                <div class="flex justify-end bg-gray-50 py-3 px-4 text-right sm:rounded-b-md sm:px-6">
                    <IndigoButton
                        :disabled="form.processing"
                    >
                        Save
                    </IndigoButton>
                </div>
            </form>
        </div>
    </div>
</template>