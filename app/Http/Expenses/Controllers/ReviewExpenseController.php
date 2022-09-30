<?php

namespace App\Http\Expenses\Controllers;

use App\Http\Expenses\ViewModels\ExpenseViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Expenses\Models\Expense;
use Inertia\Inertia;
use Inertia\Response;

class ReviewExpenseController extends Controller
{
    public function show(Expense $expense): Response
    {
        return Inertia::render('Expenses/Review', new ExpenseViewModel($expense));
    }

//    public function update(UpdateTrainingRequest $request, Training $training, ReviewTrainingAction $reviewTraining): RedirectResponse
//    {
//        $trainingData = TrainingData::from([
//            ...$training->only('status', 'state', 'description', 'provider', 'location', 'cost', 'cost_currency', 'duration', 'notes'),
//            ...$request->filteredValidatedData()
//        ]);
//
//        $reviewed = $reviewTraining->execute($training, $trainingData);
//
//        if (! $reviewed) {
//            return back()->with('flash.error', 'There was a problem when reviewing the Training request, please try again.');
//        }
//
//        return redirect()->to(route('dashboard'))->with('flash.success', "Training {$trainingData->status->statusDisplay()}.");
//    }
}
