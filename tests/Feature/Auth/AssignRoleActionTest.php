<?php

use Domain\Auth\Actions\AssignRoleAction;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;

it('assigns the specified role to a user', function () {
    $user = User::factory()->create();
    $action = app(AssignRoleAction::class);

    $action->execute($user, Role::ADMIN);

    $this->assertTrue($user->isA(Role::ADMIN->value));
});
