<?php

namespace App\Http\Reports\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Support\Models\Report;

class ReportsViewModel extends ViewModel
{
    public function search(): ?string
    {
        return request()->query('search');
    }

    public function reports(): LengthAwarePaginator
    {
        return Report::query()
            ->select('id', 'label', 'last_ran')
            ->filter(request()->query('search'))
            ->paginate();
    }

    public function models(): Collection
    {
        return collect(array_keys(config('app.reportable')))
            ->map(fn (string $model) => [
                'display' => Str::ucfirst($model),
                'value' => $model
            ]);
    }
}
