import type {PageProps} from '@inertiajs/core'

export type Currency = 'GBP' | 'USD' | 'EUR'

export type RemunerationInterval = 'hourly' | 'daily' | 'weekly' | 'monthly' | 'yearly'

export type RecurrenceInterval = 'never' | 'weekly' | 'fortnightly' | 'monthly' | 'quarterly' | 'biannually'

export type HolidayStatus = 1 | 2 | 3

export type HalfDay = 'am' | 'pm'

export type OneToOneStatus = 1 | 2 | 3

export type TrainingStatus = 1 | 2 | 3

export type TrainingState = 1 | 2 | 3

export type ExpenseStatus = 1 | 2 | 3

export type ApplicationStatus = 1 | 2 | 3

export type SelectOption = string | number | ComplexSelectOption

export type DocumentableType = 'application' | 'expense' | 'organisation' | 'person' | 'sickness' | 'vacancy'

export type ActionLogAction = 'CREATED' | 'UPDATED' | 'DELETED'

export type ContractType = 'fixed term' | 'full time' | 'part time' | 'freelancer' | 'apprenticeship' | 'internship'

export type Json =
    | null
    | boolean
    | string
    | number
    | Json[]
    | {[key: string]: Json};

export type Operator = '=' | '!=' | '<' | '>' | '<=' | '>=' | 'like'

export type StatusCode = 500 | 503 | 404 | 403

export type ConfirmablePassword = {
    password: string,
    password_confirmation: string
}

export interface PaginatorLink {
    url: string | null,
    label: string,
    active: boolean
}

export interface Paginator {
    current_page: number,
    first_page_url: string,
    from: number,
    last_page: number,
    last_page_url: string,
    links: PaginatorLink[],
    next_page_url: string | null,
    path: string,
    per_page: number,
    prev_page_url: string | null,
    to: number,
    total: number
}

export interface Paginated<T> extends Paginator {
    current_page: number,
    data: T[],
    first_page_url: string,
    from: number,
    last_page: number,
    last_page_url: string,
    links: PaginatorLink[],
    next_page_url: string | null,
    path: string,
    per_page: number,
    prev_page_url: string | null,
    to: number,
    total: number
}

export interface TabbedContentItem {
    identifier: string,
    icon: string,
    display: string
}

export interface FileInput {
    validSize: boolean,
    dragActive: boolean,
    message?: string
}

export interface Documentable {
    id: number,
    type: DocumentableType
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

export interface Organisation {
    id: number,
    name: string,
    logo: string,
    setup_at: string
}

export interface Document {
    id: number,
    name: string,
    directory: string,
    size: number,
    extension: string,
    disk: string,
    documentable_id: number,
    documentable_type: string,
    path: string
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

export interface Sickness {
    id: number,
    person_id: number,
    start_at: string,
    finish_at?: string,
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

export interface Task {
    id: number,
    objective_id: number,
    description: string,
    due_at: string,
    days_remaining: number,
    completed_at?: string
}

export interface Training {
    id: number,
    person_id: number,
    status: TrainingStatus,
    state: TrainingState,
    description: string,
    provider: string,
    location?: string,
    cost?: number,
    cost_currency?: Currency,
    duration?: number,
    notes?: string
}

export interface ExpenseType {
    id: number,
    type: string
}

export interface Expense {
    id: number,
    person_id: number,
    expense_type_id: number,
    status: ExpenseStatus,
    value: number,
    value_currency: Currency,
    date: string,
    notes?: string
}

export interface ExpenseWithType extends Expense {
    type: string
}

export interface Vacancy {
    id: string,
    contact_id: number,
    public_id: string,
    title: string,
    description: string,
    location?: string,
    contract_type?: ContractType,
    contract_length?: string,
    remuneration?: number,
    remuneration_currency?: Currency,
    open_at?: string,
    close_at?: string
}

export interface Application {
    id: number,
    vacancy_id: number,
    status: ApplicationStatus,
    name: string,
    contact_number: number | string,
    contact_email: string,
    cover_letter?: string
}

export interface ActionLog {
    id: number,
    person_id: number,
    action: ActionLogAction,
    payload: Json,
    actionable_id: number,
    actionable_type: string
}

export interface ReportCondition {
    column: string,
    operator: Operator,
    value?: string | number
}

export interface ReportConditionSet {
    type: 'and' | 'or',
    conditions: ReportCondition[]
}

export interface Report {
    id: number,
    label: string,
    model: string,
    condition_sets: ReportConditionSet[],
    last_ran?: string
}

export interface ReportableColumn {
    display: string,
    column: string,
    type: string
}

export interface CalendarEvent {
    title: string,
    start: string,
    end: string,
    color: string,
    classNames: string
}

export interface HolidayEvent extends CalendarEvent {
    extendedProps: Holiday
}

export interface SicknessEvent extends CalendarEvent {
    extendedProps: Sickness
}

export interface Breadcrumb {
    link?: string,
    display: string
}

export interface TimeStamp {
    created_at: string,
    updated_at: string
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
    notifications?: Notification[],
    impersonating: boolean
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