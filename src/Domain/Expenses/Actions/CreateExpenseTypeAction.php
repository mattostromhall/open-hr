<?php

namespace Domain\Expenses\Actions;

use Domain\Expenses\Actions\Contracts\CreateExpenseTypeActionInterface;
use Domain\Expenses\DataTransferObjects\ExpenseTypeData;
use Domain\Expenses\Models\ExpenseType;

class CreateExpenseTypeAction implements CreateExpenseTypeActionInterface
{
    public function execute(ExpenseTypeData $data): ExpenseType
    {
        return ExpenseType::create([
            'type' => $data->type
        ]);
    }
}
