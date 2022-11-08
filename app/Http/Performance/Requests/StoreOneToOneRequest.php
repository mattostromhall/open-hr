<?php

namespace App\Http\Performance\Requests;

use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Enums\RecurrenceInterval;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreOneToOneRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'person_id' => ['required', 'numeric'],
            'manager_id' => ['required', 'numeric'],
            'requester_id' => ['required', 'numeric'],
            'person_status' => ['required', new Enum(OneToOneStatus::class)],
            'manager_status' => ['required', new Enum(OneToOneStatus::class)],
            'scheduled_at' => ['required', 'date', 'after_or_equal:today'],
            'recurring' => ['required', 'boolean'],
            'recurrence_interval' => ['required', new Enum(RecurrenceInterval::class)],
            'completed_at' => ['date', 'after_or_equal:scheduled_at', 'nullable'],
            'notes' => ['string', 'nullable']
        ];
    }

    public function oneToOneData(): OneToOneData
    {
        return OneToOneData::from($this->safe()->all());
    }
}
