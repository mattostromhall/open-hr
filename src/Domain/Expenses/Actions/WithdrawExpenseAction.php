<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\Actions\Contracts\DeleteExpenseActionInterface;
use Domain\Expenses\Actions\Contracts\WithdrawExpenseActionInterface;
use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\Models\Expense;
use Domain\Files\Actions\Contracts\DeleteDocumentsActionInterface;
use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;

class WithdrawExpenseAction implements WithdrawExpenseActionInterface
{
    public function __construct(
        protected DeleteExpenseActionInterface $deleteExpense,
        protected DeleteDocumentsActionInterface $deleteDocuments,
        protected CreateNotificationActionInterface $createNotification,
        protected SendEmailNotificationActionInterface $sendEmail
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
                    notifiable_type: NotifiableType::PERSON,
                    title: 'Expense Withdrawn'
                )
            );

            $this->sendEmail->execute(
                new EmailNotificationData(
                    recipients: [$manager->email],
                    subject: 'Expense Withdrawn',
                    body: "Expense for {$data->date->toDateString()} has withdrawn by {$data->person->full_name}."
                )
            );
        }

        return $deleted;
    }
}
