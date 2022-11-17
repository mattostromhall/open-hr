<?php

namespace App\Http\Expenses\Controllers;

use App\Http\Expenses\Requests\SubmitExpenseRequest;
use App\Http\Expenses\Requests\UpdateExpenseRequest;
use App\Http\Expenses\ViewModels\ExpensesViewModel;
use App\Http\Expenses\ViewModels\ExpenseViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Expenses\Actions\AmendExpenseAction;
use Domain\Expenses\Actions\SubmitExpenseAction;
use Domain\Expenses\Actions\WithdrawExpenseAction;
use Domain\Expenses\DataTransferObjects\ExpenseData;
use Domain\Expenses\Models\Expense;
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
            $submitExpense->execute($request->submittedExpenseData());
        } catch (Exception $e) {
            return redirect(route('expense.index'))->with('flash.error', 'Part of your Expense submission failed, please review for any missing information or documents.');
        }

        return redirect(route('expense.index'))->with('flash.success', 'Expense submitted!');
    }

    public function show(Expense $expense): Response
    {
        return Inertia::render('Expenses/Show', new ExpenseViewModel($expense));
    }

    public function edit(Expense $expense): Response
    {
        return Inertia::render('Expenses/Edit', new ExpenseViewModel($expense));
    }

    public function update(UpdateExpenseRequest $request, Expense $expense, AmendExpenseAction $amendExpense): RedirectResponse
    {
        $updated = $amendExpense->execute($expense, $request->submittedExpenseData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Expense, please try again.');
        }

        return back()->with('flash.success', 'Expense updated!');
    }

    public function destroy(Expense $expense, WithdrawExpenseAction $withdrawExpense): RedirectResponse
    {
        $withdrawn = $withdrawExpense->execute($expense, ExpenseData::from($expense->toArray()));

        if (! $withdrawn) {
            return back()->with('flash.error', 'There was a problem with withdrawing the Expense, please try again.');
        }

        return redirect()->to(route('expense.index'))->with('flash.success', 'Expense withdrawn!');
    }
}
