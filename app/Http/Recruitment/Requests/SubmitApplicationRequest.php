<?php

namespace App\Http\Recruitment\Requests;

use Domain\Recruitment\DataTransferObjects\ApplicationData;
use Domain\Recruitment\DataTransferObjects\SubmittedApplicationData;
use Domain\Recruitment\Enums\ApplicationStatus;
use Domain\Recruitment\Models\Vacancy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SubmitApplicationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vacancy_public_id' => ['required', 'string', 'exists:vacancies,public_id'],
            'status' => ['required', new Enum(ApplicationStatus::class)],
            'name' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'min:2', 'max:20'],
            'contact_email' => ['required', 'email', 'max:255'],
            'cover_letter' => ['string', 'nullable'],
            'cv' => ['required', 'file', 'mimes:pdf,docx', 'max:20000']
        ];
    }

    public function submittedApplicationData(): SubmittedApplicationData
    {
        return SubmittedApplicationData::from([
            'application_data' => ApplicationData::from([
                'vacancy' => Vacancy::query()->firstWhere('public_id', $this->validated('vacancy_public_id')),
                ...$this->safe()->all()
            ]),
            'cv' => $this->validated('cv')
        ]);
    }

    public function validatedData(): array
    {
        return [
            'application_data' => ApplicationData::from(
                array_merge(
                    $this->safe([
                        'name',
                        'contact_number',
                        'contact_email',
                        'cover_letter'
                    ]),
                    [
                        'vacancy' => Vacancy::query()->firstWhere('public_id', $this->validated('vacancy_public_id')),
                        'status' => ApplicationStatus::from($this->validated('status'))
                    ]
                )
            ),
            'cv' => $this->validated('cv')
        ];
    }
}
