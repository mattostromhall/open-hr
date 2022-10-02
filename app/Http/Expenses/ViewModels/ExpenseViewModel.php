<?php

namespace App\Http\Expenses\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Expenses\Models\Expense;
use Domain\Expenses\Models\ExpenseType;
use Illuminate\Support\Collection;

class ExpenseViewModel extends ViewModel
{
    public function __construct(protected Expense $expense)
    {
        //
    }

    public function expense(): Expense
    {
        return $this->expense;
    }

    public function type()
    {
        return $this->expense
            ->type
            ->type;
    }

    public function requester()
    {
        return $this->expense
            ->person
            ->full_name;
    }

    public function status()
    {
        return $this->expense
            ->status
            ->statusDisplay();
    }

    public function expenseTypes(): Collection
    {
        return ExpenseType::query()
            ->get()
            ->map(fn (ExpenseType $expenseType) => [
                'value' => $expenseType->id,
                'display' => $expenseType->type
            ]);
    }

    public function documents(): Collection
    {
        return $this->expense
            ->documents
            ->toList();
    }
}
