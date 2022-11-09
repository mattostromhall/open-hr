<?php

namespace App\Http\Expenses\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Expenses\Models\ExpenseType;
use Domain\Organisation\Models\Department;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ExpenseTypesViewModel extends ViewModel
{
    public function expenseTypes(): LengthAwarePaginator
    {
        return ExpenseType::query()->paginate();
    }
}
