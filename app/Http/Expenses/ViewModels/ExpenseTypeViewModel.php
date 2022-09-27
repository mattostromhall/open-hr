<?php

namespace App\Http\Expenses\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Expenses\Models\ExpenseType;
use Domain\Organisation\Models\Department;
use Illuminate\Database\Eloquent\Collection;

class ExpenseTypeViewModel extends ViewModel
{
    public function __construct(protected ExpenseType $expenseType)
    {
        //
    }

    public function expenseType(): ExpenseType
    {
        return $this->expenseType;
    }
}
