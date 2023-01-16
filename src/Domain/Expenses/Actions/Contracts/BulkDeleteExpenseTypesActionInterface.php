<?php

namespace Domain\Expenses\Actions\Contracts;

interface BulkDeleteExpenseTypesActionInterface
{
    /**
     * @param array<int> $expenseTypes
     * @return bool
     */
    public function execute(array $expenseTypes): bool;
}
