<?php

namespace Domain\HR\Actions;

use Domain\HR\DataTransferObjects\HRData;
use Domain\HR\Models\HR;

class CreateHRAction
{
    public function execute(HRData $data): HR
    {
        return HR::create([
            'user_id' => $data->user->id,
            'contact_number' => $data->contact_number,
            'contact_email' => $data->contact_email
        ]);
    }
}
