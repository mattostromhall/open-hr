<?php

namespace App\Http\Expenses\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Expenses\Models\ExpenseType;
use Illuminate\Support\Collection;

class ExpensesViewModel extends ViewModel
{
    public function expenseTypes(): Collection
    {
        return ExpenseType::query()
            ->get()
            ->map(fn (ExpenseType $expenseType) => [
                'value' => $expenseType->id,
                'display' => $expenseType->type
            ]);
    }

    public function approved()
    {
        return person()
            ->expenses()
            ->select('expenses.id', 'type', 'expense_type_id', 'status', 'value', 'notes', 'expenses.created_at')
            ->join('expense_types', 'expenses.expense_type_id', '=', 'expense_types.id')
            ->whereApproved()
            ->get();
    }

    public function pending()
    {
        return person()
            ->expenses()
            ->select('expenses.id', 'type', 'expense_type_id', 'status', 'value', 'notes', 'expenses.created_at')
            ->join('expense_types', 'expenses.expense_type_id', '=', 'expense_types.id')
            ->wherePending()
            ->get();
    }

    public function rejected()
    {
        return person()
            ->expenses()
            ->select('expenses.id', 'type', 'expense_type_id', 'status', 'value', 'notes', 'expenses.created_at')
            ->join('expense_types', 'expenses.expense_type_id', '=', 'expense_types.id')
            ->whereRejected()
            ->get();
    }
}
