<?php

namespace Domain\Absences\Actions;

use Domain\Absences\DataTransferObjects\LoggedSicknessData;
use Domain\Absences\Models\Sickness;
use Domain\Files\Actions\UploadDocumentsAction;
use Domain\Files\DataTransferObjects\DocumentData;
use Domain\Files\DataTransferObjects\UploadedDocumentData;
use Domain\Files\DataTransferObjects\UploadedFileData;
use Domain\Files\Enums\DocumentableType;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class AmendSicknessAction
{
    public function __construct(
        protected UpdateSicknessAction $updateSickness,
        protected UploadDocumentsAction $uploadDocuments
    ) {
        //
    }

    public function execute(Sickness $sickness, LoggedSicknessData $data): bool
    {
        $updated = $this->updateSickness->execute($sickness, $data->sickness_data);

        if ($data->documents) {
            $this->uploadDocuments->execute(
                $this->uploadedDocuments($data->documents, $sickness)
            );
        }

        return $updated;
    }

    protected function uploadedDocuments(Collection $documents, Sickness $sickness): Collection
    {
        return $documents->map(
            fn (UploadedFile $document) =>
            UploadedDocumentData::from([
                new UploadedFileData(
                    file: $document,
                    path: "/documents/sicknesses/{$sickness->id}",
                    name: Str::beforeLast($document->getClientOriginalName(), '.')
                ),
                new DocumentData(
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
