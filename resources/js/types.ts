import type {PageProps} from '@inertiajs/inertia'

export type Currency = 'GBP' | 'USD' | 'EUR'

export type RemunerationInterval = 'hourly' | 'daily' | 'weekly' | 'monthly' | 'yearly'

export type RecurrenceInterval = 'never' | 'weekly' | 'fortnightly' | 'monthly' | 'quarterly' | 'biannually'

export type HolidayStatus = 1 | 2 | 3

export type HalfDay = 'am' | 'pm'

export type OneToOneStatus = 1 | 2 | 3

export type SelectOption = string | number | ComplexSelectOption

export type Documentable = 'application' | 'expense' | 'organisation' | 'person' | 'vacancy'

export interface FileInput {
    validExtension: boolean,
    validSize: boolean,
    dragActive: boolean,
    message?: string
}

export interface FileType {
    value: string,
    display: string
}

export interface DocumentListItem {
    name: string,
    path: string,
    kind: string,
    size?: number,
    modified?: string
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
    id: number,
    title?: string,
    body: string,
    link?: string,
    read: boolean
}

export interface ConfirmablePassword {
    password: string,
    password_confirmation: string
}

export interface User {
    id: number,
    email: string,
    active: boolean,
    reset_required: boolean
}

export interface Role {
    name: string,
    title: string,
    abilities: Ability[]
}

export interface Ability {
    name: string,
    title: string
}

export interface Person {
    id: number,
    user_id: number,
    first_name: string,
    last_name: string,
    full_name: string,
    dob: string,
    position: string,
    remuneration: number,
    remuneration_interval: RemunerationInterval,
    remuneration_currency: Currency,
    base_holiday_allocation: number,
    holiday_carry_allocation: number,
    holiday_carried: number,
    sickness_allocation: number,
    contact_number: string,
    contact_email: string,
    started_on: string,
    manager_id?: number,
    department_id?: number,
    title?: string,
    initials?: string,
    pronouns?: string,
    finished_on?: string,
    hex_code?: string
}

export interface Department {
    id: number,
    name: string,
    head_of_department_id: number
}

export interface Address {
    id: number
    address_line: string,
    country: string,
    town_city: string,
    region: string,
    postal_code: string
}

export interface Holiday {
    id: number,
    person_id: number,
    status: HolidayStatus,
    start_at: string,
    finish_at: string,
    half_day?: HalfDay,
    notes?: string
}

export interface OneToOne {
    id: number,
    person_id: number,
    manager_id: number,
    requester_id: number,
    status: OneToOneStatus,
    person_status: OneToOneStatus,
    manager_status: OneToOneStatus,
    scheduled_at: string,
    completed_at?: string,
    recurring: boolean,
    recurrence_interval: RecurrenceInterval,
    notes?: string
}

export interface Objective {
    id: number,
    person_id: number,
    title: string,
    description: string,
    due_at: string,
    days_remaining: number,
    completed_at?: string
}

export interface FlashMessage {
    success?: string,
    error?: string
}

export interface OpenHRPageProps extends PageProps {
    flash: FlashMessage,
    auth: {
        person?: Partial<Person>,
        user?: UserPageProp
    },
    permissions: {
        roles?: Role[],
        abilities?: Ability[]
    },
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

    return Object.hasOwn(notification, 'id')
        && Object.hasOwn(notification, 'body')
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

export function hasOwnProperty<X extends {}, Y extends PropertyKey> (obj: X, prop: Y): obj is X & Record<Y, unknown> {
    return Object.hasOwn(obj, prop)
}