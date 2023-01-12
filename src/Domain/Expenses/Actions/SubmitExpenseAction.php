<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\Actions\Contracts\CreateExpenseActionInterface;
use Domain\Expenses\Actions\Contracts\RequestExpenseReviewActionInterface;
use Domain\Expenses\DataTransferObjects\SubmittedExpenseData;
use Domain\Expenses\Models\Expense;
use Domain\Files\Actions\Contracts\UploadDocumentsActionInterface;
use Domain\Files\DataTransferObjects\DocumentData;
use Domain\Files\DataTransferObjects\UploadedDocumentData;
use Domain\Files\DataTransferObjects\UploadedFileData;
use Domain\Files\Enums\DocumentableType;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SubmitExpenseAction
{
    public function __construct(
        protected CreateExpenseActionInterface $createExpense,
        protected UploadDocumentsActionInterface $uploadDocuments,
        protected RequestExpenseReviewActionInterface $requestReview
    ) {
        //
    }

    public function execute(SubmittedExpenseData $data): Expense
    {
        $expense = $this->createExpense->execute($data->expense_data);

        $this->uploadDocuments->execute(
            $this->uploadedDocuments($data->documents, $expense)
        );

        $this->requestReview->execute($expense, $data->expense_data);

        return $expense;
    }

    protected function uploadedDocuments(Collection $documents, Expense $expense): Collection
    {
        return $documents->map(
            fn (UploadedFile $document) =>
            UploadedDocumentData::from([
                'fileData' => new UploadedFileData(
                    file: $document,
                    path: "/documents/expenses/{$expense->id}",
                    name: Str::beforeLast($document->getClientOriginalName(), '.')
                ),
                'documentData' => new DocumentData(
                    name: Str::beforeLast($document->getClientOriginalName(), '.'),
                    directory: "/documents/expenses/{$expense->id}",
                    size: $document->getSize(),
                    extension: $document->extension(),
                    disk: config('filesystems.default'),
                    documentable_id: $expense->id,
                    documentable_type: DocumentableType::EXPENSE
                )
            ])
        );
    }
}
