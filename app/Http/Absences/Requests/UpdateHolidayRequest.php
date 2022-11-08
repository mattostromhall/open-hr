<?php

namespace App\Http\Absences\Requests;

use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Enums\HalfDay;
use Domain\Absences\Enums\HolidayStatus;
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

    public function holidayData(): HolidayData
    {
        return HolidayData::from([
            'person' => $this->holiday->person,
            ...$this->holiday->toArray(),
            ...$this->safe()->all()
        ]);
    }
}
