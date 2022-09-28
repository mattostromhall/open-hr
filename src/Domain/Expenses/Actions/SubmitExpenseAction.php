<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Files\Actions\StoreDocumentAction;
use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\Actions\SendEmailNotificationAction;

class SubmitExpenseAction
{
    public function __construct(
        CreateExpenseAction $createExpense,
        StoreDocumentAction $storeDocument,
        CreateNotificationAction $createNotification,
        SendEmailNotificationAction $sendEmail
    ) {
        //
    }

    public function execute(ExpenseData $expenseData)
    {

    }
}
