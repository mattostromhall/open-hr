<?php

namespace App\Http\Support\ViewModels;

use Illuminate\Database\Eloquent\Collection;
use Support\Models\ActionLog;

class ActionLogViewModel extends ViewModel
{
    public function __construct(protected string $type, protected int $id)
    {
        //
    }

    public function actionLogs(): Collection
    {
        return ActionLog::query()
            ->with('person:id,first_name,last_name')
            ->where('actionable_type', $this->type)
            ->where('actionable_id', $this->id)
            ->get();
    }
}
