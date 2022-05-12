<?php

use Domain\HR\Actions\CreateHRUserAction;
use Domain\HR\DataTransferObjects\HRUserData;
use Shared\DataTransferObjects\UserData;

it('creates an hr and a user', function () {
    $action = app(CreateHRUserAction::class);
    $userData = new UserData(email: 'test@test.com', password: 'password');
    $hrUserData = new HRUserData(userData: $userData, contact_number: '+447123456789', contact_email: 'test@test.com');

    $action->execute($hrUserData);

    $this->assertDatabaseHas('users', [
        'email' => 'test@test.com'
    ]);

    $this->assertDatabaseHas('hr', [
        'contact_number' => $hrUserData->contact_number,
        'contact_email' => $hrUserData->contact_email
    ]);
});
