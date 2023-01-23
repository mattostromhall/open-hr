<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\Actions\Contracts\RequestExpenseReviewActionInterface;
use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\Models\Expense;
use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;

class RequestExpenseReviewAction implements RequestExpenseReviewActionInterface
{
    public function __construct(
        protected CreateNotificationActionInterface $createNotification,
        protected SendEmailNotificationActionInterface $sendEmail
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
                notifiable_type: NotifiableType::PERSON,
                title: 'Expense Submitted',
                link: route('expense.review.show', [
                    'expense' => $expense
                ])
            )
        );

        $this->sendEmail->execute(
            new EmailNotificationData(
                recipients: [$manager->email],
                subject: 'Expense Submitted',
                body: "Expense submitted by {$data->person->full_name}, click here to review.",
                link: route('expense.review.show', [
                    'expense' => $expense
                ])
            )
        );
    }
}
