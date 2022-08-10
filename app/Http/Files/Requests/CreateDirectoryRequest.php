<?php

namespace App\Http\Files\Requests;

use Domain\People\Models\Person;
use Illuminate\Foundation\Http\FormRequest;

class CreateDirectoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'path' => ['required', 'string']
        ];
    }
}
