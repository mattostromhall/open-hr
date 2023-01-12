<?php

namespace Domain\Expenses\Actions\Contracts;

use Domain\Expenses\DataTransferObjects\SubmittedExpenseData;
use Domain\Expenses\Models\Expense;

interface SubmitExpenseActionInterface
{
    public function execute(SubmittedExpenseData $data): Expense;
}
