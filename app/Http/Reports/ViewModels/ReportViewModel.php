<?php

namespace App\Http\Reports\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Support\Models\Report;

class ReportViewModel extends ViewModel
{
    public function __construct(protected ?Report $report = null)
    {
        //
    }

    public function report(): ?Report
    {
        return $this->report;
    }

    public function models(): Collection
    {
        return collect(array_keys(config('hr.reportable')))
            ->map(fn (string $model) => [
                'display' => Str::ucfirst($model),
                'value' => $model
            ]);
    }

    public function reportableColumns(): Collection
    {
        return collect(config('hr.reportable'))
            ->map(fn (string $model) => $model::reportableColumns());
    }

    public function downloadPath()
    {
        return session('csv.path');
    }
}
