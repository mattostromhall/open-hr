<?php

use Domain\Auth\Actions\AssignHrRoleAction;
use Domain\Auth\Models\User;

it('assigns the hr role to a user', function () {
    $user = User::factory()->create();
    $action = app(AssignHrRoleAction::class);

    $action->execute($user);

    $this->assertTrue($user->isAn('hr'));
});
