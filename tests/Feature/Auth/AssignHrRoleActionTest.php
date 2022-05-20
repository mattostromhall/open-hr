<?php

use Domain\Auth\Actions\AssignHrRoleAction;
use Domain\Auth\Models\User;

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();
    $action = app(AssignHrRoleAction::class);

    $action->execute($user);

    $this->assertTrue($user->isAn('hr'));
});
