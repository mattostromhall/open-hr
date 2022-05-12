<?php

use Domain\Auth\Actions\CreateUserAction;
use Domain\Auth\DataTransferObjects\UserData;

it('creates a user', function () {
    $action = app(CreateUserAction::class);
    $userData = new UserData(email: 'test@test.com', password: 'Test');

    $action->execute($userData);

    $this->assertDatabaseHas('users', [
        'email' => 'test@test.com'
    ]);
});
