<?php

namespace App\Http\Expenses\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Expenses\Models\Expense;

class ExpenseViewModel extends ViewModel
{
    public function __construct(protected Expense $expense)
    {
        //
    }
}
