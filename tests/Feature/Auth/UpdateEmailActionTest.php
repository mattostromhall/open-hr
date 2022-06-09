<?php

use Domain\Auth\Actions\UpdateEmailAction;
use Domain\Auth\Models\User;

it('updates the users email', function () {
    $user = User::factory()->create();
    $action = app(UpdateEmailAction::class);

    $action->execute($user, 'new@email.test');

    $this->assertTrue($user->fresh()->email === 'new@email.test');
});
