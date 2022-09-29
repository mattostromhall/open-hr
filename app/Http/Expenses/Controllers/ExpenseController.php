<?php

namespace App\Http\Expenses\Controllers;

use App\Http\Expenses\Requests\ExpenseTypeRequest;
use App\Http\Expenses\Requests\SubmitExpenseRequest;
use App\Http\Expenses\ViewModels\ExpensesViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Expenses\Actions\CreateExpenseTypeAction;
use Domain\Expenses\Actions\SubmitExpenseAction;
use Domain\Expenses\Actions\UpdateExpenseTypeAction;
use Domain\Expenses\DataTransferObjects\ExpenseTypeData;
use Domain\Expenses\DataTransferObjects\SubmittedExpenseData;
use Domain\Expenses\Models\ExpenseType;
use Exception;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ExpenseController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Expenses/Index', new ExpensesViewModel());
    }

    public function store(SubmitExpenseRequest $request, SubmitExpenseAction $submitExpense): RedirectResponse
    {
        try {
            $submitExpense->execute(
                SubmittedExpenseData::from($request->validated())
            );
        } catch (Exception) {
            return redirect(route('expense.index'))->with('flash.error', 'Part of your Expense submission failed, please review for any missing information or documents.');
        }

        return redirect(route('expense.index'))->with('flash.success', 'Expense submitted!');
    }

//    public function update(ExpenseTypeRequest $request, ExpenseType $expenseType, UpdateExpenseTypeAction $updateExpense): RedirectResponse
//    {
//        $expenseTypeData = ExpenseTypeData::from($request->validated());
//
//        $updated = $updateExpense->execute($expenseType, $expenseTypeData);
//
//        if (! $updated) {
//            return back()->with('flash.error', 'There was a problem with updating the Expense, please try again.');
//        }
//
//        return redirect()->to(route('expense.index'))->with('flash.success', 'Expense updated!');
//    }
}
