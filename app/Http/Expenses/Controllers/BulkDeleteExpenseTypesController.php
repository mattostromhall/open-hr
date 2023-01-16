<?php

namespace App\Http\Expenses\Controllers;

use App\Http\Expenses\Requests\BulkDeleteExpenseTypesRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Expenses\Actions\Contracts\BulkDeleteExpenseTypesActionInterface;
use Domain\Expenses\Models\ExpenseType;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class BulkDeleteExpenseTypesController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(BulkDeleteExpenseTypesRequest $request, BulkDeleteExpenseTypesActionInterface $bulkDelete): RedirectResponse
    {
        $this->authorize('delete', ExpenseType::class);

        $deleted = DB::transaction(
            fn () => $bulkDelete->execute($request->validated('expenseTypes'))
        );

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem deleting the selected Expense Types, please try again.');
        }

        return back()->with('flash.success', 'Selected Expense Types deleted!');
    }
}
