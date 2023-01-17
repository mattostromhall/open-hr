<script setup lang="ts">
import {computed} from 'vue'
import {useDateFormat} from '@vueuse/core'
import {Head, InertiaForm, useForm} from '@inertiajs/inertia-vue3'
import PageHeading from '@/Components/PageHeading.vue'
import LightIndigoLink from '@/Components/Controls/LightIndigoLink.vue'
import type {Address, Breadcrumb, Department, Person, Role, User} from '../../../types'
import Breadcrumbs from '@/Components/Breadcrumbs.vue'
import IndigoButton from '@/Components/Controls/IndigoButton.vue'
import usePermissions from '../../../Hooks/usePermissions'

const props = defineProps<{
    user: Pick<User, 'id'|'email'|'active'>,
    person: Person,
    people: (Pick<Person, 'id'|'full_name'>)[],
    departments: Department[],
    address: Address,
    directReports: number[],
    roles: Role[],
    allRoles: Role[]
}>()

const {can} = usePermissions()

const breadcrumbs: Breadcrumb[] = [
    {
        link: '/people',
        display: 'People'
    },
    {
        display: props.person.full_name
    }
]

const form: InertiaForm<{id: number}> = useForm({
    id: props.person.id
})

const department = computed(() =>
    props.departments.find(department => department.id === props.person.department_id)
)

const manager = computed(() => props.people.find(person => person.id === props.person.manager_id))

const directReportNames = computed(() =>
    props.people
        .filter(person => props.directReports.includes(person.id))
        .map(person => person.full_name)
)

const fullAddress = computed(() =>
    props.address
        ? `${props.address.address_line}, ${props.address.town_city}, ${props.address.region}, ${props.address.country}, ${props.address.postal_code}`
        : '-'
)

function impersonate() {
    form.post('/users/impersonate')
}
</script>

<template>
    <Head>
        <title>Person - {{ person.full_name }}</title>
    </Head>

    <PageHeading>
        <span class="font-normal">Viewing - </span>{{ person.full_name }}
        <template #link>
            <LightIndigoLink
                v-if="can('update-person')"
                :href="`/people/${person.id}/edit`"
            >
                Manage
            </LightIndigoLink>
        </template>
    </PageHeading>
    <Breadcrumbs
        :breadcrumbs="breadcrumbs"
        class="pt-8 px-8"
    />
    <section class="p-8 w-full sm:max-w-6xl">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="flex items-center justify-between py-5 px-4 sm:px-6">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        Person Information
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        View {{ person.full_name }}'s details below.
                    </p>
                </div>
                <form
                    v-if="can('impersonate-users')"
                    @submit.prevent="impersonate"
                >
                    <IndigoButton>Impersonate</IndigoButton>
                </form>
            </div>
            <div class="py-5 px-4 border-t border-gray-200 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Title
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ person.title ?? '-' }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Name
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ person.full_name }} <span class="text-gray-400">/</span> {{ person.initials }} <span class="text-gray-400">/</span> {{ person.pronouns }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Position
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ person.position }}
                        </dd>
                    </div>
                    <div
                        v-if="department"
                        class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Department
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ department?.name }}
                        </dd>
                    </div>
                    <div
                        v-if="manager"
                        class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Manager
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ manager.full_name }}
                        </dd>
                    </div>
                    <div
                        v-if="directReports.length > 0"
                        class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Direct reports
                        </dt>
                        <dd class="mt-1 space-x-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <span
                                v-for="name in directReportNames"
                                :key="name"
                                class="inline-flex px-2 text-xs font-semibold leading-5 text-indigo-800 bg-indigo-100 rounded-full"
                            >
                                {{ name }}
                            </span>
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Contact details
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <a
                                class="text-indigo-700"
                                :href="`mailto:${person.contact_email}`"
                            >{{ person.contact_email }}</a> <span class="text-gray-400">/</span> <a
                                class="text-indigo-700"
                                :href="`tel:${person.contact_number}`"
                            >{{ person.contact_number }}</a>
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Roles
                        </dt>
                        <dd class="mt-1 space-x-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <span
                                v-for="role in roles"
                                :key="role.name"
                                class="inline-flex px-2 text-xs font-semibold leading-5 text-indigo-800 bg-indigo-100 rounded-full"
                            >
                                {{ role.title }}
                            </span>
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Address
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ fullAddress }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Remuneration
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ `${person.remuneration} ${person.remuneration_currency} ${person.remuneration_interval}` }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Started on
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ useDateFormat(person.started_on, 'DD/MM/YYYY').value }}
                        </dd>
                    </div>
                    <div
                        v-if="person.finished_on"
                        class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6"
                    >
                        <dt class="text-sm font-medium text-gray-500">
                            Finished on
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ useDateFormat(person.finished_on, 'DD/MM/YYYY').value }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Holiday allocation
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ person.base_holiday_allocation + person.holiday_carry_allocation }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Holiday carried
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ person.holiday_carried }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Sickness allocation
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ person.sickness_allocation }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Date of birth
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{ useDateFormat(person.dob, 'DD/MM/YYYY').value }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
</template>