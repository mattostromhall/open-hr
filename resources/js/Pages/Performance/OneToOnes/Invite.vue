<script setup lang="ts">
import {useDateFormat} from '@vueuse/core'
import {Head, useForm} from '@inertiajs/inertia-vue3'
import type {InertiaForm} from '@inertiajs/inertia-vue3'
import type {OneToOne, OneToOneStatus} from '../../../types'
import FormLabel from '@/Components/Controls/FormLabel.vue'
import DateInput from '@/Components/Controls/DateInput.vue'
import TextAreaInput from '@/Components/Controls/TextAreaInput.vue'
import {computed} from 'vue'
import type {ComputedRef} from 'vue'
import usePerson from '../../../Hooks/usePerson'

const props = defineProps<{
    oneToOne: OneToOne,
    requester: string,
    personName: string,
    managerName: string,
    personStatus: string,
    managerStatus: string
}>()

const person = usePerson()

interface InviteData {
    scheduled_at: string,
    person_status: OneToOneStatus,
    manager_status: OneToOneStatus,
    notes?: string
}

const form: InertiaForm<InviteData> = useForm({
    scheduled_at: props.oneToOne.scheduled_at,
    person_status: props.oneToOne.person_status,
    manager_status: props.oneToOne.manager_status,
    notes: props.oneToOne.notes ?? undefined
})

const scheduledAtChanged: ComputedRef<boolean> = computed(() => {
    return useDateFormat(props.oneToOne.scheduled_at, 'DD/MM/YYYY HH:mm').value !== useDateFormat(form.scheduled_at, 'DD/MM/YYYY HH:mm').value
})

function submit(): void {
    form.patch(`/one-to-ones/${props.oneToOne.id}/invite`)
}

function accept(): void {
    if (person.value.id === props.oneToOne.person_id) {
        form.person_status = 2
    }

    if (person.value.id === props.oneToOne.manager_id) {
        form.manager_status = 2
    }

    submit()
}

function decline(): void {
    if (person.value.id === props.oneToOne.person_id) {
        form.person_status = 3
    }

    if (person.value.id === props.oneToOne.manager_id) {
        form.manager_status = 3
    }

    submit()
}

function amend(): void {
    if (person.value.id === props.oneToOne.person_id) {
        form.person_status = 2
        form.manager_status = 1
    }

    if (person.value.id === props.oneToOne.manager_id) {
        form.manager_status = 2
        form.person_status = 1
    }

    submit()
}
</script>

<template>
    <Head title="One-to-one Invite" />

    <section class="p-8">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="py-5 px-4 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    One-to-one requested by {{ requester }}
                </h3>
                <div class="mt-2 max-w-xl text-sm text-gray-500">
                    <p class="mt-1">
                        {{ personName }}: {{ personStatus }}
                    </p>
                    <p class="mt-1">
                        {{ managerName }}: {{ managerStatus }}
                    </p>
                    <p
                        v-if="oneToOne.recurring"
                        class="mt-1"
                    >
                        Recurring: {{ oneToOne.recurrence_interval }}
                    </p>
                    <p
                        v-if="oneToOne.notes"
                        class="mt-1"
                    >
                        Request info: {{ oneToOne.notes }}
                    </p>
                </div>
                <div class="mt-3">
                    <FormLabel>Scheduled at</FormLabel>
                    <div class="mt-1 max-w-xs">
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
                <div class="mt-3">
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
                <div class="mt-5 flex space-x-5">
                    <template v-if="! scheduledAtChanged">
                        <button
                            type="button"
                            class="inline-flex items-center justify-center rounded-md border border-transparent bg-green-100 py-2 px-4 font-medium text-green-700 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:text-sm"
                            @click="accept"
                        >
                            Accept
                        </button>
                        <button
                            type="button"
                            class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-100 py-2 px-4 font-medium text-red-700 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:text-sm"
                            @click="decline"
                        >
                            Decline
                        </button>
                    </template>
                    <button
                        v-else
                        type="button"
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-100 py-2 px-4 font-medium text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:text-sm"
                        @click="amend"
                    >
                        Amend
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>