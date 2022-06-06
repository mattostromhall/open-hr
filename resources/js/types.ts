import type {PageProps} from '@inertiajs/inertia'

export type Currency = 'GBP' | 'USD' | 'EUR'

export type RecurrenceInterval = 'hourly' | 'daily' | 'weekly' | 'monthly' | 'yearly'

export interface FileInput {
    validExtension: boolean,
    validSize: boolean,
    message?: string
}

export interface FileType {
    value: string,
    display: string
}

export interface ComplexSelectOption {
    value: string|number,
    display: string|number
}

export interface User {
    id: number,
    email: string
}

export interface Person {
    user_id: number,
    first_name: string,
    last_name: string,
    full_name: string,
    dob: string,
    position: string,
    remuneration: number,
    remuneration_interval: RecurrenceInterval,
    remuneration_currency: Currency,
    holiday_allocation: number,
    sickness_allocation: number,
    contact_number: string,
    contact_email: string,
    started_on: string,
    manager_id?: number,
    department_id?: number,
    title?: string,
    initials?: string,
    pronouns?: string,
    finished_on?: string
}

export interface FlashMessage {
    success?: string,
    error?: string
}

export interface OpenHRPageProps extends PageProps {
    flash: FlashMessage,
    person?: Partial<Person>,
    user?: User
}

export function isPerson(person: unknown, property: string): person is Partial<Person> {
    if (typeof person !== 'object' || ! person) {
        return false
    }

    return Object.hasOwn(person, property)
}