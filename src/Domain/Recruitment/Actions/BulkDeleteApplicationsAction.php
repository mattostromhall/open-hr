<?php

namespace Domain\Recruitment\Actions;

use Domain\Recruitment\Actions\Contracts\BulkDeleteApplicationsActionInterface;
use Domain\Recruitment\Models\Application;

class BulkDeleteApplicationsAction implements BulkDeleteApplicationsActionInterface
{
    /**
     * @param array<int> $applications
     * @return bool
     */
    public function execute(array $applications): bool
    {
        return Application::query()
            ->whereIn('id', $applications)
            ->delete();
    }
}
