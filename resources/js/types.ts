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