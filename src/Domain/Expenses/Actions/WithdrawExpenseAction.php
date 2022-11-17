<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\Models\Expense;
use Domain\Files\Actions\DeleteDocumentsAction;
use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\Actions\SendEmailNotificationAction;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;

class WithdrawExpenseAction
{
    public function __construct(
        protected DeleteExpenseAction $deleteExpense,
        protected DeleteDocumentsAction $deleteDocuments,
        protected CreateNotificationAction $createNotification,
        protected SendEmailNotificationAction $sendEmail
    ) {
        //
    }

    public function execute(Expense $expense, ExpenseData $data): bool
    {
        $this->deleteDocuments->execute($expense->documents);

        $deleted = $this->deleteExpense->execute($expense);
        $manager = $data->person->manager;

        if ($deleted && $manager) {
            $this->createNotification->execute(
                new NotificationData(
                    body: "Expense for {$data->date->toDateString()} has withdrawn by {$data->person->full_name}.",
                    notifiable_id: $manager->id,
                    notifiable_type: 'person',
                    title: 'Expense Withdrawn'
                )
            );

            $this->sendEmail->execute(
                new EmailNotificationData(
                    recipients: [$manager->user->email],
                    subject: 'Expense Withdrawn',
                    body: "Expense for {$data->date->toDateString()} has withdrawn by {$data->person->full_name}."
                )
            );
        }

        return $deleted;
    }
}
