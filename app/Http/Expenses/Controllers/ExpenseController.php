<?php

namespace App\Http\Expenses\Controllers;

use App\Http\Departments\Requests\ExpenseTypeRequest;
use App\Http\Expenses\ViewModels\ExpensesViewModel;
use App\Http\Expenses\ViewModels\ExpenseTypesViewModel;
use App\Http\Expenses\ViewModels\ExpenseTypeViewModel;
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

    public function create(): Response
    {
        return Inertia::render('Expenses/ExpenseTypes/Create');
    }

    public function store(ExpenseTypeRequest $request, CreateExpenseTypeAction $createExpense): RedirectResponse
    {
        $createExpense->execute(
            ExpenseTypeData::from($request->validated())
        );

        return redirect(route('expense-type.index'))->with('flash.success', 'Expense Type created!');
    }

    public function edit(ExpenseType $expenseType): Response
    {
        return Inertia::render('Expenses/ExpenseTypes/Edit', new ExpenseTypeViewModel($expenseType));
    }

    public function update(ExpenseTypeRequest $request, ExpenseType $expenseType, UpdateExpenseTypeAction $updateExpense): RedirectResponse
    {
        $expenseTypeData = ExpenseTypeData::from($request->validated());

        $updated = $updateExpense->execute($expenseType, $expenseTypeData);

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Expense Type, please try again.');
        }

        return redirect()->to(route('expense-type.index'))->with('flash.success', 'Expense Type updated!');
    }
}
