<?php

namespace App\Http\Files\Requests;

use Domain\Files\DataTransferObjects\DocumentData;
use Domain\Files\DataTransferObjects\UploadedDocumentData;
use Domain\Files\DataTransferObjects\UploadedFileData;
use Domain\Files\Enums\DocumentableType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

class StoreDocumentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'path' => ['required', 'string'],
            'documents' => ['required', 'array', 'min:1', 'max:10'],
            'documents.*' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,docx', 'max:20000'],
            'documentable_id' => ['required', 'numeric'],
            'documentable_type' => ['required', new Enum(DocumentableType::class)]
        ];
    }

    public function validatedData(): Collection
    {
        return collect($this->validated('documents'))
            ->map(function (UploadedFile $document) {
                return UploadedDocumentData::from([
                    new UploadedFileData(
                        file: $document,
                        path: $this->validated('path'),
                        name: Str::beforeLast($document->getClientOriginalName(), '.')
                    ),
                    new DocumentData(
                        name: Str::beforeLast($document->getClientOriginalName(), '.'),
                        directory: $this->validated('path'),
                        size: $document->getSize(),
                        extension: $document->extension(),
                        disk: config('filesystems.default'),
                        documentable_id: $this->validated('documentable_id'),
                        documentable_type: DocumentableType::from($this->validated('documentable_type'))
                    )
                ]);
            });
    }
}
