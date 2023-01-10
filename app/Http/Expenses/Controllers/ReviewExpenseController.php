<?php

namespace App\Http\Expenses\Controllers;

use App\Http\Expenses\Requests\ReviewExpenseRequest;
use App\Http\Expenses\ViewModels\ExpenseViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Expenses\Actions\ReviewExpenseAction;
use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\Models\Expense;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ReviewExpenseController extends Controller
{
    public function show(Expense $expense): Response
    {
        return Inertia::render('Expenses/Review', new ExpenseViewModel($expense));
    }

    public function update(ReviewExpenseRequest $request, Expense $expense, ReviewExpenseAction $reviewExpense): RedirectResponse
    {
        $expenseData = $request->expenseData();

        $reviewed = DB::transaction(
            fn () => $reviewExpense->execute($expense, $expenseData)
        );

        if (! $reviewed) {
            return back()->with('flash.error', 'There was a problem when reviewing the Expense, please try again.');
        }

        return redirect()->to(route('dashboard'))->with('flash.success', "Expense {$expenseData->status->statusDisplay()}.");
    }
}
