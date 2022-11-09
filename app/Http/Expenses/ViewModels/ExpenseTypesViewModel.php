<?php

namespace App\Http\Expenses\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Expenses\Models\ExpenseType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ExpenseTypesViewModel extends ViewModel
{
    public function expenseTypes(): LengthAwarePaginator
    {
        return ExpenseType::query()->paginate();
    }
}
