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

export interface UserPageProp {
    id: number,
    email: string
}

export interface PersonPageProp {
    id: number,
    full_name: string,
    initials: string
}

export interface Notification {
    body: string,
    link?: string,
    read: boolean
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
    user?: UserPageProp,
    notifications?: Notification[]
}

export function isUserPageProp(user: unknown): user is UserPageProp {
    if (typeof user !== 'object' || ! user) {
        return false
    }

    return Object.hasOwn(user, 'id') && Object.hasOwn(user, 'email')
}

export function isPersonPageProp(person: unknown): person is PersonPageProp {
    if (typeof person !== 'object' || ! person) {
        return false
    }

    return Object.hasOwn(person, 'id')
        && Object.hasOwn(person, 'full_name')
        && Object.hasOwn(person, 'initials')
}

export function isNotification(notification: unknown): notification is Notification {
    if (typeof notification !== 'object' || ! notification) {
        return false
    }

    return Object.hasOwn(notification, 'body')
        && Object.hasOwn(notification, 'read')
}

export function isNotificationsPageProp(notifications: unknown): notifications is Notification[] {
    if (! Array.isArray(notifications) || ! notifications) {
        return false
    }

    return isNotification(notifications[0]) || notifications.length === 0
}

export function isPerson(person: unknown, property: string): person is Partial<Person> {
    if (typeof person !== 'object' || ! person) {
        return false
    }

    return Object.hasOwn(person, property)
}