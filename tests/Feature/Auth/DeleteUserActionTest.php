<?php

use Domain\Auth\Actions\CreateUserAction;
use Domain\Auth\Actions\DeleteUserAction;
use Domain\Auth\DataTransferObjects\UserData;
use Domain\Auth\Models\User;

it('deletes the user', function () {
    $user = User::factory()->create();
    $action = app(DeleteUserAction::class);

    $this->assertNotSoftDeleted($user);

    $action->execute($user);

    $this->assertSoftDeleted($user);
});
