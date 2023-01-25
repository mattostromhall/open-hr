<?php

namespace App\Http\People\Requests;

use Domain\Auth\Models\User;
use Domain\Organisation\Models\Department;
use Domain\People\DataTransferObjects\DeletePersonData;
use Domain\People\DataTransferObjects\PersonData;
use Domain\People\Enums\RemunerationInterval;
use Domain\People\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Enum;
use Support\Enums\Currency;

class DeletePersonRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'new_manager_id' => ['sometimes', 'required', 'numeric', 'exists:people,id'],
            'new_head_of_department_id' => ['sometimes', 'required', 'numeric', 'exists:people,id']
        ];
    }

    public function deletePersonData(): DeletePersonData
    {
        return DeletePersonData::from([
            'person' => $this->person,
            'user' => $this->person->user,
            'department' => Department::query()->firstWhere('head_of_department_id', $this->person->id),
            ...$this->safe()->all()
        ]);
    }
}
