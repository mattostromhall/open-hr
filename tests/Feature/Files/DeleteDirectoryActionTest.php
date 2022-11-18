<?php

use Domain\Files\Actions\CreateDirectoryAction;
use Illuminate\Support\Facades\Storage;

it('deletes the directory in the specified location', function () {
    $action = app(CreateDirectoryAction::class);

    $action->execute('/organisation/testing');

    expect(Storage::exists('/organisation/testing'))->toBeTrue();

    Storage::deleteDirectory('/organisation/testing');

    expect(Storage::exists('/organisation/testing'))->toBeFalse();
});
