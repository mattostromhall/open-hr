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
}
