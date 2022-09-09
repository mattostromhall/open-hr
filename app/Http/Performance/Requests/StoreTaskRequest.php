<?php

namespace App\Http\Performance\Requests;

use Domain\People\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class StoreTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => ['required', 'string'],
            'due_at' => ['required', 'date', 'after_or_equal:today']
        ];
    }

    public function validatedData(): array
    {
        return array_merge(
            $this->safe([
                'description'
            ]),
            [
                'objective' => $this->objective,
                'due_at' => Carbon::parse($this->validated('due_at'))
            ]
        );
    }
}
