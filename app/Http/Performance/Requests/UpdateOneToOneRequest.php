<?php

namespace App\Http\Performance\Requests;

use Domain\People\Models\Person;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Enums\RecurrenceInterval;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Enum;

class UpdateOneToOneRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => [new Enum(OneToOneStatus::class)],
            'scheduled_at' => ['date', 'after_or_equal:today'],
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
                'recurring',
                'notes'
            ]),
            [
                'person' => $this->one_to_one->person,
                'manager' => $this->one_to_one->manager,
                'requester_id' => $this->one_to_one->requester_id,
                'status' => $this->validated('status') ? OneToOneStatus::from($this->validated('status')) : null,
                'scheduled_at' => $this->validated('scheduled_at') ? Carbon::parse($this->validated('scheduled_at')) : null,
                'recurrence_interval' => $this->validated('recurrence_interval') ? RecurrenceInterval::from($this->validated('recurrence_interval')) : null,
                'completed_at' => $this->validated('completed_at') ? Carbon::parse($this->validated('completed_at')) : null
            ]
        );
    }
}
