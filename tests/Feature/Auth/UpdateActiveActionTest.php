<?php

use Domain\Auth\Actions\UpdateActiveAction;
use Domain\Auth\Models\User;

it('updates the users active state', function () {
    $user = User::factory()->create();
    $action = app(UpdateActiveAction::class);

    $action->execute($user, false);

    $this->assertTrue($user->fresh()->active === false);
});
