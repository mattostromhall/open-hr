<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\Actions\Contracts\ReviewExpenseActionInterface;
use Domain\Expenses\Actions\Contracts\UpdateExpenseActionInterface;
use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\Models\Expense;
use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;

class ReviewExpenseAction implements ReviewExpenseActionInterface
{
    public function __construct(
        protected UpdateExpenseActionInterface $updateExpense,
        protected CreateNotificationActionInterface $createNotification,
        protected SendEmailNotificationActionInterface $sendEmail
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
                    notifiable_type: NotifiableType::PERSON,
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
