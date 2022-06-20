<?php

namespace App\Http\Absences\Requests;

use Domain\Absences\Enums\HalfDay;
use Domain\Absences\Enums\HolidayStatus;
use Domain\People\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Enum;

class StoreHolidayRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'person_id' => ['required', 'integer'],
            'status' => ['required', new Enum(HolidayStatus::class)],
            'start_at' => ['required', 'date', 'after_or_equal:today'],
            'finish_at' => ['required', 'date', function ($attribute, $value, $fail) {
                $startAt = Carbon::parse($this->start_at);
                $finishAt = Carbon::parse($this->finish_at);

                if ($this->half_day) {
                    return;
                }

                if ($finishAt->lessThanOrEqualTo($startAt)) {
                    $fail('Finish at date must be after Start at date.');
                }
            }],
            'half_day' => ['string', new Enum(HalfDay::class)],
            'notes' => ['string']
        ];
    }

    public function validatedData(): array
    {
        return [
            'person' => Person::find($this->person_id),
            'status' => HolidayStatus::from($this->status),
            'start_at' => Carbon::parse($this->start_at),
            'finish_at' => Carbon::parse($this->finish_at),
            'half_day' => $this->half_day ? HalfDay::from($this->half_day) : null,
            'notes' => $this->validated('notes')
        ];
    }
}
