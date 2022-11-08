<?php

namespace App\Http\Absences\Requests;

use Domain\Absences\DataTransferObjects\LoggedSicknessData;
use Domain\Absences\DataTransferObjects\SicknessData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class UpdateSicknessRequest extends FormRequest
{
    public function rules(): array
    {
        return [
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
            'sickness_data' => SicknessData::from([
                'person' => $this->sickness->person,
                ...$this->safe([
                    'start_at',
                    'finish_at',
                    'notes'
                ])
            ]),
            'documents' => $this->validated('documents') ? collect($this->validated('documents')) : null
        ]);
    }

    public function validatedData(): array
    {
        return [
            'sickness_data' => SicknessData::from(
                array_merge(
                    $this->safe([
                        'notes'
                    ]),
                    [
                        'person' => $this->sickness->person,
                        'start_at' => Carbon::parse($this->validated('start_at')),
                        'finish_at' => $this->validated('finish_at') ? Carbon::parse($this->validated('finish_at')) : null
                    ]
                )
            ),
            'documents' => $this->validated('documents') ? collect($this->validated('documents')) : null
        ];
    }
}
