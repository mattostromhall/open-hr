<?php

namespace App\Http\Reports\ViewModels;

use App\Http\Support\ViewModels\ViewModel;

class CreateReportViewModel extends ViewModel
{
    public function models(): array
    {
        return array_keys(config('app.reportable'));
    }

    public function modelColumns()
    {
        return collect(config('app.reportable'))
            ->map();
    }
}
