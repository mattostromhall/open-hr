<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import {Head} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import {useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import RequiredIcon from '@/Components/RequiredIcon.vue'
import DateInput from '@/Components/Controls/DateInput.vue'
import TextAreaInput from '@/Components/Controls/TextAreaInput.vue'
import ToggleInput from '@/Components/Controls/ToggleInput.vue'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import usePerson from '../../../Hooks/usePerson'
import type {Breadcrumb, OneToOne, RecurrenceInterval} from '../../../types'
import SelectInput from '@/Components/Controls/SelectInput.vue'
import type {ComputedRef} from 'vue'
import {computed} from 'vue'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import usePermissions from '../../../Hooks/usePermissions'

const props = defineProps<{
    oneToOne: OneToOne,
    requester: string,
    personName: string,
    managerName: string,
    personStatus: string,
    managerStatus: string,
    recurrenceIntervals: RecurrenceInterval[]
}>()

const {can} = usePermissions()

const breadcrumbs: Breadcrumb[] = [
    {
        link: '/performance?active=upcoming',
        display: 'Performance'
    },
    {
        link: `/one-to-ones/${props.oneToOne.id}`,
        display: useDateFormat(props.oneToOne.scheduled_at, 'DD/MM/YYYY HH:MM').value
    }
]

type UpdateOneToOneData = Pick<OneToOne, 'scheduled_at' | 'completed_at' | 'recurring' | 'recurrence_interval' | 'notes'>

const person = usePerson()

const canChangeRecurrence: ComputedRef<boolean> = computed(() => props.oneToOne.manager_id === person.value.id)

const form: InertiaForm<UpdateOneToOneData> = useForm({
    scheduled_at: props.oneToOne.scheduled_at,
    completed_at: props.oneToOne.completed_at,
    recurring: props.oneToOne.recurring,
    recurrence_interval: props.oneToOne.recurrence_interval,
    notes: props.oneToOne.notes
})

function submit(): void {
    form.put(`/one-to-ones/${props.oneToOne.id}`)
}
</script>

<template>
    <Head>
        <title>Editing One-to-one</title>
    </Head>

    <PageHeading>
        <span class="font-medium">Editing</span> - One-to-one
        <template #link>
            <LightIndigoLink
                v-if="can('view-one-to-one')"
                :href="`/one-to-ones/${oneToOne.id}`"
            >
                View
            </LightIndigoLink>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        class="pt-8 px-8"
    />
    <div class="space-y-6 p-8 sm:w-full sm:max-w-3xl sm:px-6 lg:col-span-9">
        <form @submit.prevent="submit">
            <div class="shadow sm:rounded-md">
                <div class="space-y-6 bg-white py-6 px-4 sm:rounded-t-md sm:p-6">
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            Update One-to-one
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Amend the details of the One-to-one.
                        </p>
                    </div>
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 text-sm text-gray-500">
                            <p>Requested by - {{ requester }}</p>
                            <div class="mt-3">
                                {{ personName }} -
                                <p
                                    class="inline-flex rounded-full px-2 text-xs font-semibold capitalize leading-5"
                                    :class="{
                                        'bg-blue-100 text-blue-800': personStatus === 'invited',
                                        'bg-green-100 text-green-800': personStatus === 'accepted',
                                        'bg-red-100 text-red-800': personStatus === 'declined'
                                    }"
                                >
                                    {{ personStatus }}
                                </p>
                                <div class="mt-3">
                                    {{ managerName }} -
                                    <p
                                        class="inline-flex rounded-full px-2 text-xs font-semibold capitalize leading-5"
                                        :class="{
                                            'bg-blue-100 text-blue-800': managerStatus === 'invited',
                                            'bg-green-100 text-green-800': managerStatus === 'accepted',
                                            'bg-red-100 text-red-800': managerStatus === 'declined'
                                        }"
                                    >
                                        {{ managerStatus }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <FormLabel>Scheduled at <RequiredIcon /></FormLabel>
                            <div class="mt-1">
                                <DateInput
                                    v-model="form.scheduled_at"
                                    :error="form.errors.scheduled_at"
                                    :time-enabled="true"
                                    input-id="scheduled_at"
                                    input-name="scheduled_at"
                                    @reset="form.clearErrors('scheduled_at')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <FormLabel>Completed at</FormLabel>
                            <div class="mt-1">
                                <DateInput
                                    v-model="form.completed_at"
                                    :error="form.errors.completed_at"
                                    :time-enabled="true"
                                    input-id="completed_at"
                                    input-name="completed_at"
                                    @reset="form.clearErrors('completed_at')"
                                />
                            </div>
                        </div>
                        <div
                            v-if="canChangeRecurrence"
                            class="col-span-6"
                        >
                            <FormLabel>Recurring?</FormLabel>
                            <div class="mt-1">
                                <ToggleInput v-model="form.recurring" />
                            </div>
                        </div>
                        <div
                            v-if="canChangeRecurrence && form.recurring"
                            class="col-span-6 sm:col-span-4"
                        >
                            <FormLabel>Recurring</FormLabel>
                            <div class="mt-1">
                                <SelectInput
                                    v-model="form.recurrence_interval"
                                    :options="recurrenceIntervals"
                                    :error="form.errors.recurrence_interval"
                                    @reset="form.clearErrors('recurrence_interval')"
                                />
                            </div>
                        </div>
                        <div class="col-span-6">
                            <FormLabel>Notes</FormLabel>
                            <div class="mt-1">
                                <TextAreaInput
                                    v-model="form.notes"
                                    :error="form.errors.notes"
                                    input-id="notes"
                                    input-name="notes"
                                    @reset="form.clearErrors('notes')"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end bg-gray-50 py-3 px-4 text-right sm:rounded-b-md sm:px-6">
                    <IndigoButton
                        :disabled="form.processing"
                    >
                        Submit
                    </IndigoButton>
                </div>
            </div>
        </form>
    </div>
</template>