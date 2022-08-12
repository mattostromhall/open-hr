<?php

namespace App\Http\Performance\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Auth\Models\User;
use Illuminate\Database\Eloquent\Collection;

class PerformanceViewModel extends ViewModel
{
    public function directReports()
    {
        return person()->directReports->map(
            fn ($directReport) => $directReport->only('id', 'full_name')
        );
    }

    public function manager()
    {
        return person()->manager->only('id', 'full_name');
    }

    public function objectives()
    {
        return person()->objectives;
    }
}
