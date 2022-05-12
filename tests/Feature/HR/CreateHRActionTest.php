<?php

use Domain\HR\Actions\CreateHRAction;
use Domain\HR\DataTransferObjects\HRData;
use Shared\Models\User;

it('creates an hrR for a user', function () {
    $user = User::factory()->create();
    $action = app(CreateHRAction::class);
    $hrData = new HRData(user: $user, contact_number: '+447123456789', contact_email: 'test@test.com');

    $action->execute($hrData);

    $this->assertDatabaseHas('hr', [
        'user_id' => $hrData->user->id,
        'contact_number' => $hrData->contact_number,
        'contact_email' => $hrData->contact_email
    ]);
});
