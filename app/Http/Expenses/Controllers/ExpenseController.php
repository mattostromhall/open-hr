<?php

namespace App\Http\Expenses\Controllers;

use App\Http\Expenses\Requests\ExpenseTypeRequest;
use App\Http\Expenses\Requests\SubmitExpenseRequest;
use App\Http\Expenses\ViewModels\ExpensesViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Expenses\Actions\CreateExpenseTypeAction;
use Domain\Expenses\Actions\UpdateExpenseTypeAction;
use Domain\Expenses\DataTransferObjects\ExpenseTypeData;
use Domain\Expenses\Models\ExpenseType;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ExpenseController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Expenses/Index', new ExpensesViewModel());
    }

    public function store(SubmitExpenseRequest $request, CreateExpenseTypeAction $submitExpense): RedirectResponse
    {
        $submitExpense->execute(
            ExpenseTypeData::from($request->validated())
        );

        return redirect(route('expense.index'))->with('flash.success', 'Expense submitted!');
    }

    public function update(ExpenseTypeRequest $request, ExpenseType $expenseType, UpdateExpenseTypeAction $updateExpense): RedirectResponse
    {
        $expenseTypeData = ExpenseTypeData::from($request->validated());

        $updated = $updateExpense->execute($expenseType, $expenseTypeData);

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Expense, please try again.');
        }

        return redirect()->to(route('expense.index'))->with('flash.success', 'Expense updated!');
    }
}
