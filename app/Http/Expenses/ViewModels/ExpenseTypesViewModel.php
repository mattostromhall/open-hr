<?php

namespace App\Http\Expenses\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Expenses\Models\ExpenseType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ExpenseTypesViewModel extends ViewModel
{
    public function search(): ?string
    {
        return request()->query('search');
    }

    public function expenseTypes(): LengthAwarePaginator
    {
        return ExpenseType::query()
            ->filter(request()->query('search'))
            ->paginate()
            ->withQueryString();
    }
}
