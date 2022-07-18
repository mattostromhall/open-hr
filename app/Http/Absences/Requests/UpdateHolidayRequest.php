<?php

namespace App\Http\Absences\Requests;

use Domain\Absences\Enums\HalfDay;
use Domain\Absences\Enums\HolidayStatus;
use Domain\People\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Enum;

class UpdateHolidayRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => [new Enum(HolidayStatus::class)],
            'start_at' => ['required_with:finish_at', 'date', 'after_or_equal:today'],
            'finish_at' => ['required_with:start_at', 'date', function ($attribute, $value, $fail) {
                $startAt = Carbon::parse($this->start_at);
                $finishAt = Carbon::parse($this->finish_at);

                if ($this->half_day) {
                    return;
                }

                if ($finishAt->lessThan($startAt)) {
                    $fail('Finish at date must be equal to or after Start at date.');
                }
            }],
            'half_day' => ['string', new Enum(HalfDay::class)],
            'notes' => ['string']
        ];
    }

    public function validatedData(): array
    {
        return [
            'person' => $this->holiday->person,
            'status' => $this->status ? HolidayStatus::from($this->status) : null,
            'start_at' => $this->start_at ? Carbon::parse($this->start_at) : null,
            'finish_at' => $this->finish_at ? Carbon::parse($this->finish_at) : null,
            'half_day' => $this->half_day ? HalfDay::from($this->half_day) : null,
            'notes' => $this->validated('notes')
        ];
    }

    public function filteredValidatedData(): array
    {
        return array_filter($this->validatedData());
    }
}
