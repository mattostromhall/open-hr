<?php

namespace Domain\Absences\Actions;

use Domain\Absences\Actions\Contracts\CreateSicknessActionInterface;
use Domain\Absences\Actions\Contracts\LogSicknessActionInterface;
use Domain\Absences\DataTransferObjects\LoggedSicknessData;
use Domain\Absences\Models\Sickness;
use Domain\Files\Actions\Contracts\UploadDocumentsActionInterface;
use Domain\Files\DataTransferObjects\DocumentData;
use Domain\Files\DataTransferObjects\UploadedDocumentData;
use Domain\Files\DataTransferObjects\UploadedFileData;
use Domain\Files\Enums\DocumentableType;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class LogSicknessAction implements LogSicknessActionInterface
{
    public function __construct(
        protected CreateSicknessActionInterface $createSickness,
        protected UploadDocumentsActionInterface $uploadDocuments
    ) {
        //
    }

    public function execute(LoggedSicknessData $data): Sickness
    {
        $sickness = $this->createSickness->execute($data->sickness_data);

        if ($data->documents) {
            $this->uploadDocuments->execute(
                $this->uploadedDocuments($data->documents, $sickness)
            );
        }

        return $sickness;
    }

    protected function uploadedDocuments(Collection $documents, Sickness $sickness): Collection
    {
        return $documents->map(
            fn (UploadedFile $document) =>
            UploadedDocumentData::from([
                'fileData' => new UploadedFileData(
                    file: $document,
                    path: "/documents/sicknesses/{$sickness->id}",
                    name: Str::beforeLast($document->getClientOriginalName(), '.')
                ),
                'documentData' => new DocumentData(
                    name: Str::beforeLast($document->getClientOriginalName(), '.'),
                    directory: "/documents/sicknesses/{$sickness->id}",
                    size: $document->getSize(),
                    extension: $document->extension(),
                    disk: config('filesystems.default'),
                    documentable_id: $sickness->id,
                    documentable_type: DocumentableType::SICKNESS
                )
            ])
        );
    }
}
