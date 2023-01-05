<?php

namespace App\Http\Performance\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Performance\Models\Training;
use Illuminate\Database\Eloquent\Collection;

class ManageTrainingViewModel extends ViewModel
{
    public function active(): string
    {
        return request()->query('active', 'assign');
    }

    public function directReports()
    {
        return person()->directReports->map(
            fn ($directReport) => $directReport->only('id', 'full_name')
        );
    }

    public function started(): Collection
    {
        return Training::query()
            ->forPeople(person()->directReports)
            ->approved()
            ->started()
            ->get();
    }

    public function notStarted(): Collection
    {
        return Training::query()
            ->forPeople(person()->directReports)
            ->approved()
            ->notStarted()
            ->get();
    }

    public function completed(): Collection
    {
        return Training::query()
            ->forPeople(person()->directReports)
            ->approved()
            ->completed()
            ->get();
    }

    public function awaitingApproval(): Collection
    {
        return Training::query()
            ->forPeople(person()->directReports)
            ->awaitingApproval()
            ->get();
    }
}
