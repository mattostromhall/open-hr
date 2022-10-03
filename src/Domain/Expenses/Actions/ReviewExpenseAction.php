<?php

namespace Domain\Expenses\Actions;

use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;
use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\Models\Expense;
use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\Actions\SendEmailNotificationAction;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;

class ReviewExpenseAction
{
    public function __construct(
        protected UpdateExpenseAction $updateExpense,
        protected CreateNotificationAction $createNotification,
        protected SendEmailNotificationAction $sendEmail
    ) {
        //
    }

    public function execute(Expense $expense, ExpenseData $data): bool
    {
        $updated = $this->updateExpense->execute($expense, $data);

        if ($updated) {
            $this->createNotification->execute(
                new NotificationData(
                    body: "Your submitted Expense has been updated to {$data->status->statusDisplay()}",
                    notifiable_id: $data->person->id,
                    notifiable_type: 'person',
                    title: 'Submitted Expense reviewed',
                    link: route('expense.show', [
                        'expense' => $expense
                    ])
                )
            );

            $this->sendEmail->execute(
                new EmailNotificationData(
                    recipients: [$data->person->user->email],
                    subject: 'Submitted Expense reviewed',
                    body: "Your submitted Expense has been updated to {$data->status->statusDisplay()}",
                    link: route('expense.show', [
                        'expense' => $expense
                    ])
                )
            );
        }

        return $updated;
    }
}