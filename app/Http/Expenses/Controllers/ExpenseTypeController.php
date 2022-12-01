<?php

namespace App\Http\Expenses\Controllers;

use App\Http\Expenses\Requests\ExpenseTypeRequest;
use App\Http\Expenses\ViewModels\ExpenseTypesViewModel;
use App\Http\Expenses\ViewModels\ExpenseTypeViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Expenses\Actions\CreateExpenseTypeAction;
use Domain\Expenses\Actions\DeleteExpenseTypeAction;
use Domain\Expenses\Actions\UpdateExpenseTypeAction;
use Domain\Expenses\Models\ExpenseType;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ExpenseTypeController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): Response
    {
        $this->authorize('view', ExpenseType::class);

        return Inertia::render('Expenses/ExpenseTypes/Index', new ExpenseTypesViewModel());
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize('create', ExpenseType::class);

        return Inertia::render('Expenses/ExpenseTypes/Create');
    }

    /**
     * @throws AuthorizationException
     */
    public function store(ExpenseTypeRequest $request, CreateExpenseTypeAction $createExpense): RedirectResponse
    {
        $this->authorize('create', ExpenseType::class);

        $createExpense->execute($request->expenseTypeData());

        return redirect(route('expense-type.index'))->with('flash.success', 'Expense Type created!');
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(ExpenseType $expenseType): Response
    {
        $this->authorize('update', ExpenseType::class);

        return Inertia::render('Expenses/ExpenseTypes/Edit', new ExpenseTypeViewModel($expenseType));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(ExpenseTypeRequest $request, ExpenseType $expenseType, UpdateExpenseTypeAction $updateExpense): RedirectResponse
    {
        $this->authorize('update', ExpenseType::class);

        $updated = $updateExpense->execute($expenseType, $request->expenseTypeData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Expense Type, please try again.');
        }

        return redirect()->to(route('expense-type.index'))->with('flash.success', 'Expense Type updated!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(ExpenseType $expenseType, DeleteExpenseTypeAction $deleteExpenseType): RedirectResponse
    {
        $this->authorize('delete', ExpenseType::class);

        $deleted = $deleteExpenseType->execute($expenseType);

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem with deleting the Expense Type, please try again.');
        }

        return redirect()->to(route('expense-type.index'))->with('flash.success', 'Expense Type deleted!');
    }
}
