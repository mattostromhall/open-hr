<?php

namespace App\Http\Performance\Requests;

use Domain\People\Models\Person;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Enums\RecurrenceInterval;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
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
            'recurring' => ['boolean'],
            'recurrence_interval' => [new Enum(RecurrenceInterval::class)],
            'completed_at' => ['date', 'after_or_equal:scheduled_at'],
            'notes' => ['string', 'nullable']
        ];
    }

    public function validatedData(): array
    {
        return array_merge(
            $this->safe([
                'requester_id',
                'recurring',
                'notes'
            ]),
            [
                'person' => Person::find($this->validated('person_id')),
                'manager' => Person::find($this->validated('manager_id')),
                'person_status' => OneToOneStatus::from($this->validated('person_status')),
                'manager_status' => OneToOneStatus::from($this->validated('manager_status')),
                'scheduled_at' => Carbon::parse($this->validated('scheduled_at')),
                'recurrence_interval' => RecurrenceInterval::from($this->validated('recurrence_interval')),
                'completed_at' => $this->validated('completed_at') ? Carbon::parse($this->validated('completed_at')) : null
            ]
        );
    }
}
