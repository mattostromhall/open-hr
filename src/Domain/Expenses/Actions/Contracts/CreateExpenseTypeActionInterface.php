<?php

namespace Domain\Expenses\Actions\Contracts;

use Domain\Expenses\DataTransferObjects\ExpenseTypeData;
use Domain\Expenses\Models\ExpenseType;

interface CreateExpenseTypeActionInterface
{
    public function execute(ExpenseTypeData $data): ExpenseType;
}
