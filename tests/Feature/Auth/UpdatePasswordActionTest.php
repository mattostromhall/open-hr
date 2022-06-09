<?php

use Domain\Auth\Actions\UpdatePasswordAction;
use Domain\Auth\Models\User;
use Illuminate\Support\Facades\Hash;

it('updates the users password', function () {
    $user = User::factory()->create();
    $action = app(UpdatePasswordAction::class);

    $action->execute($user, 'NewPassword');

    $this->assertTrue(
        Hash::check('NewPassword', $user->fresh()->password)
    );
});
