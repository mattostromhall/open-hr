<?php

namespace Domain\Expenses\Actions\Contracts;

use Domain\Expenses\Models\Expense;

interface DeleteExpenseActionInterface
{
    public function execute(Expense $expense): bool;
}
