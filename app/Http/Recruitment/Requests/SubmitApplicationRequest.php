<?php

namespace App\Http\Recruitment\Requests;

use Domain\Recruitment\Enums\ApplicationStatus;
use Domain\Recruitment\Models\Vacancy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SubmitApplicationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vacancy_id' => ['required', 'numeric', 'exists:vacancies,id'],
            'status' => ['required', new Enum(ApplicationStatus::class)],
            'name' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'min:2', 'max:20'],
            'contact_email' => ['required', 'email', 'max:255'],
            'cover_letter' => ['string', 'nullable']
        ];
    }

    public function validatedData(): array
    {
        return array_merge(
            $this->safe([
                'name',
                'contact_number',
                'contact_email',
                'cover_letter'
            ]),
            [
                'vacancy' => Vacancy::query()->find($this->validated('vacancy_id')),
                'status' => ApplicationStatus::from($this->validated('status'))
            ]
        );
    }
}
