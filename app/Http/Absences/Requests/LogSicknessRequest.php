<?php

namespace App\Http\Absences\Requests;

use Domain\Absences\DataTransferObjects\LoggedSicknessData;
use Domain\Absences\DataTransferObjects\SicknessData;
use Illuminate\Foundation\Http\FormRequest;

class LogSicknessRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'person_id' => ['required', 'numeric'],
            'start_at' => ['required', 'date'],
            'finish_at' => ['date', 'nullable'],
            'notes' => ['string', 'nullable'],
            'documents' => ['array', 'min:1', 'max:10', 'nullable'],
            'documents.*' => ['file', 'mimes:jpg,jpeg,png,pdf,docx', 'max:20000']
        ];
    }

    public function loggedSicknessData(): LoggedSicknessData
    {
        return LoggedSicknessData::from([
            'sickness_data' => SicknessData::from($this->safe()->all()),
            'documents' => $this->validated('documents') ? collect($this->validated('documents')) : null
        ]);
    }
}
