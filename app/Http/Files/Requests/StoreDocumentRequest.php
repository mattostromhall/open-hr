<?php

namespace App\Http\Files\Requests;

use Domain\Files\DataTransferObjects\DocumentData;
use Domain\Files\DataTransferObjects\UploadedDocumentData;
use Domain\Files\DataTransferObjects\UploadedFileData;
use Domain\People\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class StoreDocumentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'path' => ['required', 'string'],
            'documents' => ['required', 'array', 'min:1', 'max:10'],
            'documents.*' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,docx', 'max:20000'],
            'documentable_id' => ['required', 'numeric'],
            'documentable_type' => [
                'required',
                'string',
                Rule::in(['application', 'expense', 'organisation', 'person', 'vacancy']),
            ]
        ];
    }

    public function validatedData(): Collection
    {
        return collect($this->validated('documents'))
            ->map(function () {
                return UploadedDocumentData::from([
                    new UploadedFileData(),
                    new DocumentData()
                ]);
            });
    }
}
