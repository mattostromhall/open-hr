<?php

namespace Domain\Expenses\Actions\Contracts;

use Domain\Expenses\DataTransferObjects\ExpenseTypeData;
use Domain\Expenses\Models\ExpenseType;

interface UpdateExpenseTypeActionInterface
{
    public function execute(ExpenseType $expenseType, ExpenseTypeData $data): bool;
}
