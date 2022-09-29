<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\Models\Expense;
use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\Actions\SendEmailNotificationAction;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;

class RequestExpenseReviewAction
{
    public function __construct(
        protected CreateNotificationAction $createNotification,
        protected SendEmailNotificationAction $sendEmail
    ) {
        //
    }

    public function execute(Expense $expense, ExpenseData $data): void
    {
        $manager = $data->person->manager;

        if (! $manager) {
            return;
        }

        $this->createNotification->execute(
            new NotificationData(
                body: "Expense submitted by {$data->person->full_name}, click here to review.",
                notifiable_id: $manager->id,
                notifiable_type: 'person',
                title: 'New Expense Submitted',
                link: route('expense.review.show', [
                    'expense' => $expense
                ])
            )
        );

        $this->sendEmail->execute(
            new EmailNotificationData(
                recipients: [$manager->user->email],
                subject: 'New Expense Submitted',
                body: "Expense submitted by {$data->person->full_name}, click here to review.",
                link: route('expense.review.show', [
                    'expense' => $expense
                ])
            )
        );
    }
}
