<?php

namespace App\Http\Reports\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CreateReportViewModel extends ViewModel
{
    public function models(): Collection
    {
        return collect(array_keys(config('app.reportable')))
            ->map(fn (string $model) => [
                'display' => Str::ucfirst($model),
                'value' => $model
            ]);
    }

    public function reportableColumns(): Collection
    {
        return collect(config('app.reportable'))
            ->map(fn (string $model) => $model::reportableColumns());
    }
}
