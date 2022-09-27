<?php

namespace App\Http\Expenses\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Expenses\Models\ExpenseType;
use Domain\Organisation\Models\Department;
use Illuminate\Database\Eloquent\Collection;

class ExpenseTypesViewModel extends ViewModel
{
    public function expenseTypes(): Collection
    {
        return ExpenseType::query()->get();
    }
}
