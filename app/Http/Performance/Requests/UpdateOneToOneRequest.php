<?php

namespace App\Http\Performance\Requests;

use Domain\Performance\DataTransferObjects\OneToOneData;
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
            'person_status' => [new Enum(OneToOneStatus::class)],
            'manager_status' => [new Enum(OneToOneStatus::class)],
            'scheduled_at' => ['date', 'after_or_equal:today'],
            'recurring' => ['boolean'],
            'recurrence_interval' => [new Enum(RecurrenceInterval::class)],
            'completed_at' => ['date', 'after_or_equal:scheduled_at', 'nullable'],
            'notes' => ['string', 'nullable']
        ];
    }

    public function oneToOneData(): OneToOneData
    {
        return OneToOneData::from([
            'person' => $this->one_to_one->person,
            'manager' => $this->one_to_one->manager,
            ...$this->one_to_one->toArray(),
            ...$this->safe()->all()
        ]);
    }
}
